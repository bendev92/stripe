<?php
namespace Dfe\Stripe\Facade;
use Stripe\Customer as C;
// 2017-02-10
final class Customer extends \Df\StripeClone\Facade\Customer {
	/**
	 * 2017-02-10
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::cardAdd()
	 * @used-by \Df\StripeClone\Payer::newCard()
	 * @param C $c
	 * @param string $token
	 * @return string
	 */
	function cardAdd($c, $token) {return $c->sources->create(['source' => $token])->id;}

	/**
	 * 2017-02-10
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::create()
	 * @used-by \Df\StripeClone\Payer::newCard()
	 * @param array(string => mixed) $p
	 * @return C
	 */
	function create(array $p) {return C::create($p);}

	/**
	 * 2017-02-10
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::id()
	 * @used-by \Df\StripeClone\Payer::newCard()
	 * @param C $c
	 * @return string
	 */
	function id($c) {return $c->id;}

	/**
	 * 2017-02-10
	 * «When requesting the ID of a customer that has been deleted,
	 * a subset of the customer’s information will be returned,
	 * including a deleted property, which will be true.»
	 * https://stripe.com/docs/api/php#retrieve_customer
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::_get()
	 * @used-by \Df\StripeClone\Facade\Customer::get()
	 * @param int $id
	 * @return C|null
	 */
	protected function _get($id) {/** @var C $c */return dfo($c = C::retrieve($id), 'deleted') ? null : $c;}

	/**
	 * 2017-02-11
	 * 2017-10-12
	 * `sources`:
	 * 		«The customer’s payment sources, if any.»
	 * 		https://stripe.com/docs/api#customer_object-sources
	 * `data`:
	 * 		«The list contains all payment sources that have been attached to the customer.»
	 * 		https://stripe.com/docs/api#customer_object-sources-data
	 * @override
	 * @see \Df\StripeClone\Facade\Customer::cardsData()
	 * @used-by \Df\StripeClone\Facade\Customer::cards()
	 * @param C $c
	 * @return \Stripe\Card[]
	 * @see \Dfe\Stripe\Facade\Charge::cardData()
	 */
	protected function cardsData($c) {return $c->sources->{'data'};}
}