<?php
namespace app\models;

class Status {
    const SUCCESS = 'success';
    const ERROR = 'error';
    const OK = 200;
    const CREATED = 201;
    const ACCEPTED = 202;
    const NON_AUTHORITATIVE_INFORMATION = 203;
    const NO_CONTENT = 204;
    const RESET_CONTENT = 205;

    const MULTIPLE_CHOICES = 300;
    const MOVED_PERMANENTLY = 301;
    const FOUND = 302;
    const TEMPORARY_REDIRECT = 307;
    const PERMANENT_REDIRECT = 308;

    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const PAYMENT_REQUIRED = 402;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const METHOD_NOT_ALLOWED = 405;
    const REQUEST_TIMEOUT = 408;

    const INTERNAL_SERVER_ERROR = 500;
    const HTTP_VERSION_NOT_SUPPORTED = 505;
}
