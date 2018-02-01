<?php

namespace Controller;

use Core\Controller;
use Model\User;
use Model\UserRepository;
use Service\UserService;

class WithdrawController extends Controller
{
    public function dashboardAction()
    {
        $user_service = new UserService(new UserRepository());
        $user = $user_service->getCurrentUser();

        if (!$user_service->isLoggedUser($user)) {
            unset($_SESSION['token']);
            $this->redirect('/');
        }

        $receivers = $user_service->getReceivers($user);

        $this->view->generate('Withdraw/dashboard', [
            'funds' => $user->getFunds(),
            'receivers' => $receivers,
        ]);
    }

    public function withdrawAction()
    {
        if (!isset($_POST['amount']) || !isset($_POST['receiver']) || intval($_POST['receiver']) <= 0) {
            $this->redirect('/dashboard', ['withdraw_error' => 'Fill in the Amount field and choose a receiver.']);
        }

        if (!is_numeric($_POST['amount'])) {
            $this->redirect('/dashboard', ['withdraw_error' => 'Amount should be a decimal number.']);
        }

        $user_service = new UserService(new UserRepository());
        /** @var User $user */
        $user = $user_service->getCurrentUser();

        // Check if user logged in
        if (!$user_service->isLoggedUser($user)) {
            unset($_SESSION['token']);
            $this->redirect('/');
        }

        $amount = round( floatval($_POST['amount']), 2 );
        // Check if user doesn't have enough funds
        if ($amount > $user->getFunds()) {
            $this->redirect('/dashboard', ['withdraw_error' => 'You have not enough funds.']);
        }

        // Send funds
        $withdraw_result = $user_service->withdrawFunds($amount, $user, intval($_POST['receiver']));
        if (!$withdraw_result) {
            $this->redirect('/dashboard', ['withdraw_error' => 'You have not enough funds.']);
        }

        $this->redirect('/dashboard', ['withdraw_success' => 'Funds have been sent successfully.']);
    }
}