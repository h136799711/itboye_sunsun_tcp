<?php
/**
 * 注意：本内容仅限于博也公司内部传阅,禁止外泄以及用于其他的商业目的
 * User: hebidu<346551990@qq.com>
 * Date: 2017-10-19 10:23
 * Copyright: ${year} www.itboye.com Boye Inc. All rights reserved.
 * Revision History Version
 ********1.0.0********************
 * file created @ 2017-10-19 10:23
 *********************************
 ********1.0.1********************
 *
 *********************************
 */

namespace sunsun\transfer_station;


interface DeviceClientInterface
{
    /**
     * 设备信息
     * @return mixed
     */
    public function deviceInfo();

    /**
     * 固件更新
     * @return mixed
     */
    public function firmwareUpdate();
}