<?php

namespace Controller;

use Core\Controller;
use Model\UserRepository;
use Service\UserService;

class WithdrawController extends Controller
{
    public function dashboardAction()
    {
        $user_service = new UserService(new UserRepository());
        $user = $user_service->getCurrentUser();

        $user_service->validateLoggedUser($user);

        $receivers = $user_service->getReceivers($user);

        $this->view->generate('Withdraw/dashboard', [
            'funds' => $user->getFunds(),
            'receivers' => $receivers,
        ]);
    }

    public function withdrawAction()
    {
        $receiver_id = isset($_POST['receiver']) ? intval($_POST['receiver']) : 0;
        if (!isset($_POST['amount']) || $receiver_id <= 0) {
            $this->redirect('/dashboard', [
                'withdraw_error' => 'Fill in the Amount field and choose a receiver.'
            ]);
        }

        if (!is_numeric($_POST['amount']) || $_POST['amount'] <= 0) {
            $this->redirect('/dashboard', [
                'withdraw_error' => 'Amount should be a positive decimal number.'
            ]);
        }

        $user_service = new UserService(new UserRepository());
        $user = $user_service->getCurrentUser();

        // Check if user logged in
        $user_service->validateLoggedUser($user);

        $amount = round(floatval($_POST['amount']), 2);

        session_write_close();
        // Send funds
        $withdraw_result = $user_service->withdrawFunds($amount, $user, $receiver_id);
        session_start();

        if (!$withdraw_result) {
            $this->redirect('/dashboard', [
                'withdraw_error' => 'You have not enough funds.'
            ]);
        }

        $this->redirect('/dashboard', [
            'withdraw_success' => 'Funds have been sent successfully.'
        ]);
    }
}