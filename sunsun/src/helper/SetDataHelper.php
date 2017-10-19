<?php
/**
 * 注意：本内容仅限于博也公司内部传阅,禁止外泄以及用于其他的商业目的
 * User: hebidu<346551990@qq.com>
 * Date: 2017-10-19 11:37
 * Copyright: ${year} www.itboye.com Boye Inc. All rights reserved.
 * Revision History Version
 ********1.0.0********************
 * file created @ 2017-10-19 11:37
 *********************************
 ********1.0.1********************
 *
 *********************************
 */

namespace sunsun\helper;


class SetDataHelper
{

    /**
     * 将对象实例的getter数据封装为数组
     *
     * @param $instance
     * @param array $properties 属性名称数组，属性名称必须是驼峰式
     * @return array
     */
    public static function getDataArray($instance, $properties = [])
    {
        $className = get_class($instance);
        $ref = new \ReflectionClass($className);
        $data = [];
        foreach ($properties as $propName) {
            $key = self::convertUnderline($propName);
            $methodName = 'get' . ucfirst($key);
            if ($ref->hasMethod($methodName)) {
                $data[$propName] = $instance->$methodName();
            }
        }
        return $data;
    }

    public static function convertUnderline($str)
    {
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ', '', lcfirst($str));
        return $str;
    }
    // member function
    public static function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }

    /**
     * 要求：
     * 属性必须是驼峰式且需要set方法作为反射调用
     * 数据数组中键可以是下划线也可以同属性名称一致
     * 不要出现这种属性名称 wh_hH ，改成 wh_hh
     * 例:
     *  数据数组 $data = ['propCame'=>'value1','prop_came'=>'value2']
     *  类
     *  class PropTest {
     *       private $propCame;
     *       public function setPropCame($value){
     *          $this->propCame = $value;
     *       }
     *  }
     *  上述 数据数组的propCame和prop_came都可以转换到PropTest的propCame属性
     * @param $instance
     * @param null $data
     */
    public static function setData($instance, $data = null)
    {
        if (!empty($data) && is_array($data)) {
            $className = get_class($instance);
            $ref = new \ReflectionClass($className);
            $properties = $ref->getProperties();
            foreach ($properties as $obj) {
                $name = $obj->name;
                $key = self::uncamelize($name);
                $methodName = 'set' . ucfirst($name);
                if ($ref->hasMethod($methodName)) {
                    if (array_key_exists($key, $data)) {
                        $instance->$methodName($data[$key]);
                    } elseif ((array_key_exists($name, $data))) {
                        $instance->$methodName($data[$name]);
                    }
                }
            }
        }
    }

    // construct
    public function __construct()
    {
        // TODO construct
    }

    // override function __toString()

    // member variables

    // getter setter

}