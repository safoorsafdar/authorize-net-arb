<?php
namespace SafoorSafdar\AuthorizeNetARB\Bridge;

// this is a fix of crappy auto loading in authorize.net lib.
class_exists('AuthorizeNetException', true);

class AuthorizeNetARB extends \AuthorizeNetARB
{

}
