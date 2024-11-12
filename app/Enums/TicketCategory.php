<?php

namespace App\Enums;

enum TicketCategory: string
{
    case POINT_OF_SALE = 'Point of Sale';
    case BACK_OFFICE_COMPUTER = 'Back-office Computer';
    case TABLET = 'Tablet';
    case MFC_PRINTER_SCANNER = 'MFC Printer/Scanner';
    case RECEIPT_PRINTER = 'Receipt Printer';
    case TELEPHONE = 'Telephone';
    case INTERNET = 'Internet';
    case LOGIN_ISSUES = 'Login Issues';
    case OTHER = 'Other';
}
