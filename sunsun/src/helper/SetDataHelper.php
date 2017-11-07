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
    // member function
    public function __construct()
    {
        // TODO construct
    }

    public static function getAllProperties($instance)
    {
        $parent = new \ReflectionClass($instance);
        $properties = $parent->getProperties();
        while (($parent = $parent->getParentClass())) {
            $properties = array_merge($parent->getProperties(), $properties);
        }
        return $properties;
    }

    /**
     * 将对象实例的get函数返回的数据封装为数组,键都是小写字母加下划线形式
     * 支持父类的属性封装,get函数只支持 public 作用域
     * @param object $instance 对象
     * @param array $properties 属性名称数组，属性名称必须是驼峰式
     * @return array
     */
    public static function getDataArrayFrom($instance, $properties = [])
    {
        $ref = new \ReflectionClass($instance);
        $data = [];
        if (empty($properties)) {
            $parent = $ref;
            $properties = $parent->getProperties();
            while (($parent = $parent->getParentClass())) {
                $properties = array_merge($parent->getProperties(), $properties);
            }
        }
        foreach ($properties as $vo) {
            if ($vo instanceof \ReflectionProperty) {
                $propName = self::uncamelize($vo->getName());
            } else {
                $propName = self::uncamelize($vo);
            }
            $key = self::convertUnderline($propName);
            $methodName = 'get' . ucfirst($key);

            if ($ref->hasMethod($methodName)) {
                $method = $ref->getMethod($methodName);
                if ($method->isPublic()) {
                    $data[$propName] = $instance->$methodName();
                }
            }
        }
        return $data;
    }

    public static function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }

    public static function convertUnderline($str)
    {
        $str = ucwords(str_replace('_', ' ', $str));
        $str = str_replace(' ', '', lcfirst($str));
        return $str;
    }

    // construct

    /**
     * 将传入的键值对数组通过set方法进行赋值到一个类实例的属性
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
            // $properties = $ref->getProperties();
            $properties = self::getAllProperties($instance);
            foreach ($properties as $obj) {
                $name = $obj->name;
                $key = self::uncamelize($name);
                $methodName = 'set' . ucfirst($name);
                if ($ref->hasMethod($methodName)) {
                    $method = $ref->getMethod($methodName);
                    if ($method->isPublic()) {
                        if (array_key_exists($key, $data)) {
                            $method->invoke($instance, $data[$key]);
                        } elseif ((array_key_exists($name, $data))) {
                            $method->invoke($instance, $data[$name]);
                        }
                    }
                }
            }
        }
    }

}