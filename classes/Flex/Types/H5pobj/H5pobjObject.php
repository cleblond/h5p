<?php

declare(strict_types=1);

/**
 * @package    Grav\Common\Flex
 *
 * @copyright  Copyright (c) 2015 - 2021 Trilby Media, LLC. All rights reserved.
 * @license    MIT License; see LICENSE file for details.
 */

namespace Grav\Plugin\H5prepo\Flex\Types\H5pobj;

use Grav\Common\Flex\Types\Generic\GenericObject;

/**
 * Class H5pobjObject
 * @package Grav\Common\Flex\Generic
 *
 * @extends FlexObject<string,GenericObject>
*/
class H5pobjObject extends GenericObject
{

    public function getSummary() {
        $delimiter = \Grav\Common\Grav::instance()['config']['site']['summary']['delimiter'] ?? '===';
        $summary = explode($delimiter, $this->content);
        return $summary[0] ?? '';
    }



}
