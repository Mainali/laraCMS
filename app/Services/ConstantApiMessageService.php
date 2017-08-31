<?php
namespace App\Services;


/**
 * The UserService class.
 *
 * @author Rubens Mariuzzo <rubens@mariuzzo.com>
 */
class ConstantApiMessageService
{
    
    /*
     *@Defining Constant Message for API
    */
    const RequireMessage='This is Required Field !.';
    const SucessMessage='You are sucessfully registered in our system.';
     const DeviceIdResponse='DeviceId empty';
    const DeviceResponse='Device added sucessfully';
    const PasswordMisMatchMessage='Sorry,Password and Confirm password did not match.';
    const AvailableMessage='Dear Customer.You are already registered in our system but you are currently in active.Do you want to reactivate again?';
    const APIRequireMessage='API Key Required.';
    const InvalidApiMessage='Invalid API Key';
    const InvalidAuthMessage='Bad request! Please keep valid Auth Key.';
    const AuthKeyRequiredMessage='Access Token Is Required.';
    const LoginFailureMessage='You are not registered yet.Please,go to sigup section.';
    const LoginSucessMessage='You are logged in sucessfully.';
    const InputMessage='Please Provide Valid Input.';
    const DeviceRequireMessage='Please provide device id and device Token';
    const EmailConfirmationMessage='Please click following link to confirm your registration.';
    const InvalidEmailMessage='Sorry,your email is not valid.';
    const createdEmailResponse='You are sucessfully registered to our system. Please confirm our link to login.';
    const forgotEmailResponse='Your activation link has been sent.Please confirm link to reset your password.';
    const EmailSubject='EK CMS Account Verification.';
    const ForgotEmailSubject='Ek CMS account security Token.';
    const ConfirmationMessage='Thank you for your confirmation.Please go to login section for login.';
    const NotConfirmationMessage='You have not confirmed the activation link.Please,confirm it.';
    const EmailVerifyMessage='Please verify the activation link before you login.';
    const NewSmsResponse='Dear Customer,Your Pin Number has been sent to your Mobile Number via SMS.';
    const BlockMessage='Dear Customer.You are blocked for 24 hours.The system will be activated after 24 hours later.';
    const ReactivationMessage='Dear Customer,You are now activated and go to email for verification.';
    const InvalidPassword='Dear Customer,The password you entered is invalid.';
    const SucessPasswordChangeMessage='Your Password has changed sucessfully.';
    const UnauthorizeTokenMessage='Please provide valid token.';
    const NoDataAvailable='No Data found';
    const InvalidResponse='Invalid Parameter';
    const EmptyMessage='Field cant be empty';
     const WrongvalidationResponse='Wrong UserName and Password';
     const DeleteUserResponse='User Deleted Sucessfully';
     const ActivationMessage='Sucessfully uploaded.';
}
