<?php
/**
 * Url.php
 *
 * PHP Version 8.2+
 *
 * @author David Ghyse <davidg@webcraftdg.fr>
 * @version XXX
 * @package fractalCms\content\traits
 */
namespace fractalCms\content\traits;

use Exception;
use Yii;

trait Url
{

    /**
     * Get route
     *
     * @param string|array $route
     * @return array
     * @throws Exception
     */
    public function getRoute(string | array $route)
    {
        try {
            if (is_string($route) === true) {
                $route = [$route];
            }
            return $route;
        } catch (Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            throw $e;
        }
    }


}
