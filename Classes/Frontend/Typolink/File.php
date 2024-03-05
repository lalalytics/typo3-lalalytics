<?php

namespace Z7\Lalalytics\Frontend\Typolink;

use TYPO3\CMS\Frontend\Typolink\FileOrFolderLinkBuilder;
use TYPO3\CMS\Frontend\Typolink\LinkResultInterface;

/**
 * Adds data attribute(s) for lalalytics to file downloads to track them
 * properly if something like fal_securedownload is used which obscures
 * the original filename in the fileDump hash.
 *
 * Usage:
 *
 * ```
 * $GLOBALS['TYPO3_CONF_VARS']['FE']['typolinkBuilder']['file'] =
 *   \Z7\Lalalytics\Frontend\Typolink\File::class;
 * ```
 *
 * Careful, this can potentially conflict with other extensions overriding
 * the file linkbuilder.
 */
final class File extends FileOrFolderLinkBuilder
{
    public function build(
        array &$linkDetails,
        string $linkText,
        string $target,
        array $conf
    ): LinkResultInterface {
        $filename = $linkDetails['file']?->getName() ?? null;
        $mimetype = $linkDetails['file']?->getMimetype() ?? null;
        return parent::build($linkDetails, $linkText, $target, $conf)
            ->withAttribute('data-lala-filename', $filename)
            ->withAttribute('data-lala-mimetype', $mimetype);
    }
}
