<?php

declare(strict_types=1);

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

                // Static init script (CSP: served from 'self')
                $event->getAssetCollector()->addJavaScript(
                    'lala_init',
                    'EXT:lalalytics/Resources/Public/JavaScript/LalaInit.js',
                    [],
                    ['priority' => true]
                );

                // External tracking script (CSP allows i.lalalytics.com or 'self' for proxy)
                $event->getAssetCollector()->addJavaScript(
                    'lala_tracker',
                    $endpoint . '/ingest/js/v1/' . $code,
                    ['async' => 'async'],
                    ['priority' => true, 'external' => true]
                );
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

                // Output event data as JSON (type="application/json" is not executed, no CSP restriction)
                $event->getAssetCollector()->addInlineJavaScript(
                    'lala_events_data',
                    $jsonEvents,
                    ['type' => 'application/json', 'id' => 'lala-events-data'],
                    []
                );

                // Static events handler script (CSP: served from 'self')
                $event->getAssetCollector()->addJavaScript(
                    'lala_events',
                    'EXT:lalalytics/Resources/Public/JavaScript/lalalytics.js',
                    [],
                    []
                );
            }
        }
    }

    private function getRequest(): ServerRequestInterface
    {
        return $GLOBALS['TYPO3_REQUEST'];
    }
}
