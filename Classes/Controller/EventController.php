<?php

declare(strict_types=1);

namespace Z7\Lalalytics\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Site\SiteFinder;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use Z7\Lalalytics\Domain\Model\Event;
use Z7\Lalalytics\Domain\Repository\EventRepository;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;

class EventController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    public function __construct(
        protected readonly ModuleTemplateFactory $moduleTemplateFactory,
        protected EventRepository $eventRepository,
        protected SiteFinder $siteFinder
    ) {}

    public function initializeAction()
    {
        if (!$GLOBALS['BE_USER']->check('modules', 'site_LalalyticsBackend')) {
            die('access denied');
        }
    }

    public function listAction(): ResponseInterface
    {
        $events = $this->eventRepository->findAll();
        $this->view->assign('events', $events);
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($moduleTemplate->renderContent());
    }

    public function newAction(): ResponseInterface
    {
        $sites = $this->siteFinder->getAllSites();
        $this->view->assign('sites', $sites);
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($moduleTemplate->renderContent());
    }

    public function createAction(Event $newEvent): ResponseInterface
    {
        $this->addFlashMessage($this->ll('event.created'));
        $this->eventRepository->add($newEvent);
        $uri = $this->uriBuilder->uriFor('list');
        return $this->responseFactory->createResponse(307)
            ->withHeader('Location', $uri);
    }

    public function editAction(Event $event): ResponseInterface
    {
        $sites = $this->siteFinder->getAllSites();
        $this->view->assign('sites', $sites);
        $this->view->assign('event', $event);
        $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
        $moduleTemplate->setContent($this->view->render());
        return $this->htmlResponse($moduleTemplate->renderContent());
    }

    public function updateAction(Event $event): ResponseInterface
    {
        $this->addFlashMessage($this->ll('event.updated'));
        $this->eventRepository->update($event);
        $uri = $this->uriBuilder->uriFor('list');
        return $this->responseFactory->createResponse(307)
            ->withHeader('Location', $uri);
    }

    public function deleteAction(Event $event): ResponseInterface
    {
        $this->addFlashMessage($this->ll('event.deleted'));
        $this->eventRepository->remove($event);
        $uri = $this->uriBuilder->uriFor('list');
        return $this->responseFactory->createResponse(307)
            ->withHeader('Location', $uri);
    }

    private function ll($id): string
    {
        return LocalizationUtility::translate('LLL:EXT:lalalytics/Resources/Private/Language/locallang_db.xlf:' . $id);
    }
}
