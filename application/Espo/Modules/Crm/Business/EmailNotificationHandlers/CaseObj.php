<?php
/************************************************************************
 * This file is part of EspoCRM.
 *
 * EspoCRM - Open Source CRM application.
 * Copyright (C) 2014-2020 Yuri Kuznetsov, Taras Machyshyn, Oleksiy Avramenko
 * Website: https://www.espocrm.com
 *
 * EspoCRM is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * EspoCRM is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with EspoCRM. If not, see http://www.gnu.org/licenses/.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "EspoCRM" word.
 ************************************************************************/

namespace Espo\Modules\Crm\Business\EmailNotificationHandlers;

class CaseObj extends \Espo\Core\Injectable
{
    protected $dependencyList = [
        'entityManager'
    ];

    protected $inboundEmailEntityHash = array();

    public function getSmtpParams($type, $case, $user = null)
    {
        $inboundEmailId = $case->get('inboundEmailId');

        if (!$inboundEmailId) return;

        if (!array_key_exists($inboundEmailId, $this->inboundEmailEntityHash)) {
            $this->inboundEmailEntityHash[$inboundEmailId] = $this->getInjection('entityManager')->getEntity('InboundEmail', $inboundEmailId);
        }

        $inboundEmail = $this->inboundEmailEntityHash[$inboundEmailId];

        if (!$inboundEmail) return;

        $emailAddress = $inboundEmail->get('emailAddress');

        if (!$emailAddress) return;

        return array(
            'replyToAddress' => $emailAddress
        );
    }
}