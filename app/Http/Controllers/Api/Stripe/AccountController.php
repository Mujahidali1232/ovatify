<?php

namespace App\Http\Controllers\Api\Stripe;

use Illuminate\Http\Request;
use Stripe\Account;
use Stripe\AccountLink;
use Illuminate\Http\JsonResponse;
use Exception;

class AccountController extends StripeBaseController
{
    public function create(Request $request): JsonResponse
    {
        try {
            $account = Account::create($request->all());
            return $this->successResponse($account);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function retrieve(string $id): JsonResponse
    {
        try {
            $account = Account::retrieve($id);
            return $this->successResponse($account);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $account = Account::update($id, $request->all());
            return $this->successResponse($account);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function delete(string $id): JsonResponse
    {
        try {
            $account = Account::retrieve($id);
            $account->delete();
            return $this->successResponse(['deleted' => true]);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function createLink(Request $request): JsonResponse
    {
        try {
            $link = AccountLink::create($request->all());
            return $this->successResponse($link);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function createExternalAccount(Request $request, string $id): JsonResponse
    {
        try {
            $account = Account::retrieve($id);
            $externalAccount = $account->external_accounts->create($request->all());
            return $this->successResponse($externalAccount);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function listExternalAccounts(Request $request, string $id): JsonResponse
    {
        try {
            $account = Account::retrieve($id);
            $externalAccounts = $account->external_accounts->all($request->all());
            return $this->successResponse($externalAccounts);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function deleteExternalAccount(string $acc_id, string $ext_id): JsonResponse
    {
        try {
            $account = Account::retrieve($acc_id);
            $account->external_accounts->retrieve($ext_id)->delete();
            return $this->successResponse(['deleted' => true]);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}
