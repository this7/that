<?php
/**
 * this7 PHP Framework
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2016-2018 Yan TianZeng<qinuoyun@qq.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://www.ub-7.com
 */
namespace this7\that;

/**
 * 应用内调
 */
class that {
    /**
     * 链接驱动
     * @var [type]
     */
    protected static $link = [];
    /**
     * 初始APP核心
     * @var [type]
     */
    protected static $app;

    public function __construct($app) {
        self::$app = $app;
    }

    /**
     * 单例调用
     * @return [type] [description]
     */
    protected static function single($name) {
        $class = 'server\controllers\\' . $name . md5($name);
        if (!isset(self::$link[$name])) {
            self::$link[$name] = new $class();
        }

        return self::$link[$name];
    }

    public function __call($method, $params) {
        $name = $params[0];
        routes::setApiClass($method, $name, 2);
        array_shift($params);
        return call_user_func_array([self::single($method), $name], $params);
    }

    public static function __callStatic($name, $arguments) {
        return call_user_func_array([static::single(), $name], $arguments);
    }
}
