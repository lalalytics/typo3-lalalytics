<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Directive;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Mutation;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationCollection;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Scope;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\UriValue;
use TYPO3\CMS\Core\Type\Map;

/**
 * CSP configuration for lalalytics extension.
 *
 * Allows loading the tracking script from i.lalalytics.com.
 * All other scripts (init snippet, events handler) are static files
 * served from 'self', which is allowed by default.
 */
return Map::fromEntries([
    Scope::frontend(),
    new MutationCollection(
        // Allow loading tracking script from i.lalalytics.com
        new Mutation(
            MutationMode::Extend,
            Directive::ScriptSrc,
            new UriValue('https://i.lalalytics.com'),
        ),
        // Allow sending tracking data to i.lalalytics.com (fetch/XHR)
        new Mutation(
            MutationMode::Extend,
            Directive::ConnectSrc,
            new UriValue('https://i.lalalytics.com'),
        ),
    ),
]);
