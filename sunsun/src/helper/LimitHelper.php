<?php
/**
 * 注意：本内容仅限于博也公司内部传阅,禁止外泄以及用于其他的商业目的
 * @author    hebidu<346551990@qq.com>
 * @copyright 2018 www.itboye.com Boye Inc. All rights reserved.
 * @link      http://www.itboye.com/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 * Revision History Version
 ********1.0.0********************
 * file created @ 2018-08-25 17:31
 *********************************
 ********1.0.1********************
 *
 *********************************
 */

namespace sunsun\helper;


class LimitHelper
{
    private $reqCnt = [];
    private $elapseTime = 5;
    private $limitCnt = 30;

    public function __construct($limitCnt = 30, $elapseTime = 5)
    {
        $this->limitCnt = $limitCnt;
        $this->elapseTime = $elapseTime;
    }

    public function ifOverLimit()
    {
        $now = time();
        $limit = 0;
        // 大于该索引的都要去除
        $expiredTimeIndex = -1;
        for ($i = 0; $i < count($this->reqCnt); $i++) {
            $passedTime = $this->reqCnt[$i];
            if ($passedTime[0] <= $now - $this->elapseTime) {
                $expiredTimeIndex = $i;
            } else {
                $limit += $passedTime[1];
            }
        }
        $this->reqCnt = array_reverse($this->reqCnt);
        while ($expiredTimeIndex-- > 0) {
            array_pop($this->reqCnt);
        }
        $this->reqCnt = array_reverse($this->reqCnt);

        if ($limit >= $this->limitCnt) {
            return true;
        }

        if (count($this->reqCnt) > 0 && $this->reqCnt[count($this->reqCnt) - 1][0] == $now) {
            $this->reqCnt[count($this->reqCnt) - 1][1]++;
        } else {
            array_push($this->reqCnt, [$now, 1]);
        }
        return false;
    }

}