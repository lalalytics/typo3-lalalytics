<?php

namespace Z7\Lalalytics\EventListener;

use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Page\Event\BeforeJavaScriptsRenderingEvent;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\ApplicationType;
use Z7\Lalalytics\Domain\Repository\EventRepository;

class AssetRenderer
{
    protected EventRepository $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function __invoke(BeforeJavaScriptsRenderingEvent $event): void
    {
        if (ApplicationType::fromRequest($this->getRequest())->isFrontend() && $event->isInline()) {
            $site = $this->getRequest()->getAttribute('site');
            $context = GeneralUtility::makeInstance(Context::class);
            $currentLanguageId = $context->getPropertyFromAspect('language', 'id');
            $config = $site->getLanguageById($currentLanguageId)->toArray();

            // add tracking code
            $enabled = (bool) ($config['lalalytics_enabled'] ?? false) && !(bool) ($GLOBALS['TSFE']->tmpl->setup['config.']['lalalytics_disabled'] ?? false);
            $code = (string) ($config['lalalytics_code'] ?? '');
            if ($enabled && !empty($code)) {
                $endpoint = (bool) ($config['lalalytics_proxy'] ?? false) ? '/_lala' : 'https://i.lalalytics.com';
                $event->getAssetCollector()->addInlineJavaScript('lala_snippet_1', "(function(w,l='lala'){w[l]=w[l]||function(k,v){(w[l].q=w[l].q||[]).push([k,v])};})(window);", [], ['priority' => true]);
                $event->getAssetCollector()->addInlineJavaScript('lala_snippet_2', '', ['src' => $endpoint . '/ingest/js/v1/' . $code, 'async' => 'async'], ['priority' => true]);
            }

            // add custom events
            $events = $this->eventRepository->findBySite($site->getIdentifier())->toArray();
            $groupedEvents = [];
            foreach ($events as $e) {
                if (!isset($groupedEvents[$e->getType()])) {
                    $groupedEvents[$e->getType()] = [];
                }
                $groupedEvents[$e->getType()][] = $e->toArray();
            }
            if (count($events) > 0) {
                $jsonEvents = json_encode($groupedEvents);
                $js = <<<EOD
                (function() {
                    const events = $jsonEvents;
                    const _lala = (n,t) => (typeof window['lala'] === "function") ? lala(n,t) : console.log(n,t);
                    const parseTags = (t) => Array.isArray(window.lalaGlobalTags) ? {tags: window.lalaGlobalTags.concat(t)} : {tags: t};
                    const defaultHandler = (ev) => {
                        events[ev.type].forEach((e) => {
                            const el = ev.target.closest(e.sel);
                            if (el !== null) {
                                let tags = e.tags || [];
                                const t = el.getAttribute(e.attr);
                                if (e.attr && t) {
                                    tags = tags.concat(t);
                                }
                                _lala(e.name, parseTags(tags));
                            }
                        });
                    }
                    const hashchangeHandler = (ev) => events[ev.type].filter((e) => e.sel === location.hash).forEach((e) => _lala(e.name, parseTags(e.tags)));
                    Object.keys(events).forEach((e) => window.addEventListener(e, (e === 'hashchange' ? hashchangeHandler : defaultHandler), { passive: true }))
                })();
                EOD;
                $event->getAssetCollector()->addInlineJavaScript('lala', $js);
            }
        }
    }

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
