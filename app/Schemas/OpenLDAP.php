<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Schemas;

use Adldap\Schemas\OpenLDAP as BaseOpenLDAP;

/**
 * Description of OpenLDAP
 *
 * @author marcelo
 */
class OpenLDAP extends BaseOpenLDAP {
    
    public function objectClassGroup()
    {
        return 'posixGroup';
    }
    
}
