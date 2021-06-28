<?php

namespace App\Enums;

class TransactionEnum
{
    const SUCESS_FIND = 'Transactions Found';
    const SUCESS_CREATED = 'Transaction Created';
    const ERR_NOT_DATA = 'No Transactions Found';
    const ERR_NOT_FOUND = 'This transaction is not found';
    const ERR_NOT_EXIST_PAYEE = 'Not Exist Wallet';
    const ERR_NOT_EXIST_PAYER = 'Not Exist Wallet';
    const ERR_NOT_TYPE_PERMITED = 'Type Not Permited For Pay';
    const ERR_INSUFFICIENT_AMOUNT = 'Insufficient Amount';
    const ERR_TRANSACTION_NOT_CREATED = 'Transaction Not Created';
    const ERR_TRANSACTION_NOT_AUTHORIZED = 'Transaction Not Authorized';
    const ERR_PAYEE_NOT_UPDATED = 'Faild Updated Payee';
    const ERR_PAYER_NOT_UPDATED = 'Faild Updated Payee';
    const ERR_NOT_SEND_NOTIFICATION = 'Faild For Send Notification';
}
