<?php

/*
 * SPDX-License-Identifier: AGPL-3.0-only
 */

declare(strict_types=1);

namespace App;

use Foresi\Shared\Infrastructure\Kernel\ForesiKernel;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * The application: every installed Foresi module registers itself.
 */
final class Kernel extends BaseKernel
{
    use ForesiKernel;
}
