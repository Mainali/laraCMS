<?php
namespace App\Services;


/**
 * The UserService class.
 *
 * @author Rubens Mariuzzo <rubens@mariuzzo.com>
 */
class ConstantStatusService
{
    
    /*
     *@Defining Constant Status
    */
    const CREATEDSTATUS = 201;
    const UNAUTHORIZEDSTATUS = 401;
    const OKSTATUS = 200;
    const BADREQUESTSTATUS=400;
    const PAYMENTREQUIREDSTATUS=402;
    const FORBIDDENSTATUS=403;
    const NOTFOUNDSTATUS=404;
    const NOTIMPLEMENTEDSTATUS=501;
    const TIMEOUTSTATUS=503;
    const NOTMODIFIEDSTATUS=304;
    const NoContentStatus=204;
}
