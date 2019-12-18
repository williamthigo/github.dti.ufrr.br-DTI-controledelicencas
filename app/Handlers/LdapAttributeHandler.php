<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LdapAttributeHandler
 *
 * @author marcelo
 */
namespace App\Handlers;

use App\Pessoa as EloquentUser;
use Adldap\Models\User as LdapUser;
use Illuminate\Support\Facades\Request;

class LdapAttributeHandler
{
    /**
     * Synchronizes ldap attributes to the specified model.
     *
     * @param LdapUser     $ldapUser
     * @param EloquentUser $eloquentUser
     *
     * @return void
     */
    public function handle(LdapUser $ldapUser, EloquentUser $eloquentUser)
    {
            foreach($ldapUser->mail as $mail) {
                if(preg_match('/ufrr.br$/', $mail)) {
                    $eloquentUser->email = $mail;
                } else {
                    $eloquentUser->email_alternativo = $mail;
                }
            }
            $eloquentUser->nome = $ldapUser->uid[0];
            // $eloquentUser->name = $ldapUser->getCommonName();
            // $eloquentUser->primeiro_nome = $ldapUser->givenname[0];
            // $eloquentUser->ultimo_nome = $ldapUser->sn[0];
            // $eloquentUser->matricula = $ldapUser->getEmployeeNumber();
            // $eloquentUser->departamento = $ldapUser->getDepartmentNumber();
            // $eloquentUser->cargo = $ldapUser->getTitle();
            // $eloquentUser->telefone_institucional = $ldapUser->getTelephoneNumber();
            // $eloquentUser->telefone_pessoal = $ldapUser->mobile[0];
            // $tipoConta = \App\TipoConta::where('employeetype',$ldapUser->employeetype[0])->first();
            // $eloquentUser->tipo_conta_id = $tipoConta ? $tipoConta->id : null;
            // $eloquentUser->cadastro_ip = !empty(Request::server('HTTP_X_FORWARDED_FOR'))
            //     ? Request::server('HTTP_X_FORWARDED_FOR')
            //     : Request::server('REMOTE_ADDR');

    }

}
