<?php
/**
 * ControllerInterface.php
 *
 * PHP Version 8.2+
 *
 * @author David Ghyse <davidg@webcraftdg.fr>
 * @version XXX
 * @package fractalCms\content\interfaces
 */

namespace fractalCms\content\interfaces;

use fractalCms\content\models\Content;
use fractalCms\content\models\Tag;

interface ControllerInterface
{
    /**
     * Get content
     *
     * @return Content|Tag|null
     */
    public function getTarget() : Content | Tag | null;
}
