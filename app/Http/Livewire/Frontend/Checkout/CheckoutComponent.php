<?php

namespace App\Http\Livewire\Frontend\Checkout;

use App\Models\Coupon;
use App\Models\PaymentMethod;
use App\Models\ShippingCompany;
use App\Models\UserAddress;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CheckoutComponent extends Component
{
    use LivewireAlert;

    public $cartSubTotal;
    public $cartTax;
    public $cartTotal;
    public $cartCoupon;
    public $couponCode;
    public $cartShipping;
    public $cartDiscount;
    public $addresses;
    public $userAddressId = 0;
    public $shippingCompanies;
    public $shippingCompanyId = 0;
    public $paymentMethods;
    public $paymentMethodId = 0;
    public $paymentMethodCode;
    public $shippingCompanyDetails;
    public $idTransp;
    public $transp;
    public $nameShipping;
    public $modelShipping;
    public $idShipping;



    protected $listeners = [
        'update_cart' => 'mount'
    ];

    public function mount()
    {
        $this->addresses = auth()->user()->addresses;
        $this->userAddressId = session()->has('saved_user_address_id') ? session()->get('saved_user_address_id') : '';
        $this->shippingCompanyId = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->paymentMethodId = session()->has('saved_payment_method_id') ? session()->get('saved_payment_method_id') : '';
        $this->cartSubTotal = getNumbersOfCart()->get('subtotal');
        $this->cartTax = getNumbersOfCart()->get('productTaxes');
        $this->cartDiscount = getNumbersOfCart()->get('discount');
        $this->cartShipping = getNumbersOfCart()->get('shipping');
        $this->cartTotal = getNumbersOfCart()->get('total');
        if ($this->userAddressId == '') {
            $this->shippingCompanies = collect([]);
        } else {
            $this->getShippingCompanies();
        }
        $this->paymentMethods = PaymentMethod::whereStatus(true)->get();
    }

    public function applyDiscount()
    {
        if (getNumbersOfCart()) {
            $coupon = Coupon::whereCode($this->couponCode)->whereStatus(true)->first();
            if (!$coupon) {
                $this->couponCode = '';
                $this->alert('error', 'Coupon is invalid');
            }

            if ($coupon->greater_than > getNumbersOfCart()->get('subtotal')) {
                $this->couponCode = '';
                $this->alert('warning', 'Subtotal must greater than $' . $coupon->greater_than);
            }

            $couponValue = $coupon->discount($this->cartSubTotal);
            if ($couponValue < 0) {
                $this->alert('error', 'product coupon is invalid');
            }

            session()->put('coupon', [
                'code' => $coupon->code,
                'value' => $coupon->value,
                'discount' => $couponValue
            ]);

            $this->couponCode = session()->get('coupon')['code'];
            $this->emit('update_cart');
            $this->alert('success', 'Coupon is applied successfully');
        }

        $this->couponCode = '';
        $this->alert('error', 'No products available in your cart');
    }

    public function removeCoupon()
    {
        session()->remove('coupon');
        $this->couponCode = '';
        $this->emit('update_cart');
        $this->alert('success', 'remove coupon successfully');
    }

    public function getShippingCompanies()
    {



        $cepSelected = $this->addresses->where('id', $this->userAddressId)->first();

        $client = new Client();
        // $this->shippingCompanies = ShippingCompany::get();
        $headers = [
            'token' => '23ebe3711b3cf36d58f89252b243ad1a',
            'Content-Type' => 'application/json'
        ];
        $body = '{
                "cepOrigem": "04941080",
                "cepDestino": "' . $cepSelected->zipcode . '",
                "vlrMerc": 50,
                "pesoMerc": 0.5,
                "volumes": [
                {
                    "peso": 0,
                    "altura": 0,
                    "largura": 0,
                    "comprimento": 0,
                    "tipo": "string",
                    "valor": 0,
                    "quantidade": 0
                }
                ],
                "produtos": [
                {
                    "peso": 0,
                    "altura": 0,
                    "largura": 0,
                    "comprimento": 0,
                    "valor": 0,
                    "quantidade": 0
                }
                ],
                "servicos": [
                "string"
                ],
                "ordernar": "string"
            }';
        $request = new Request('POST', 'https://portal.kangu.com.br/tms/transporte/simular', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        $resp = json_decode($res->getBody(), true);

        //    dd($resp);
        $comPontosRetira = array();
        $semPontosRetira = array();
        foreach ($resp as $item) {
            if (isset($item['pontosRetira'])) {
                $comPontosRetira[] = $item;
            } else {
                $semPontosRetira[] = $item;
            }
        }
        $this->shippingCompanies = $resp;
    }

    // Lifecycle Hooks updating (UserAddressId)
    public function updatingUserAddressId()
    {
        session()->forget('saved_user_address_id');
        session()->forget('saved_shipping_company_id');
        session()->forget('shipping');
        session()->put('saved_user_address_id', $this->userAddressId);
        $this->userAddressId = session()->has('saved_user_address_id') ? session()->get('saved_user_address_id') : '';
        $this->shippingCompanyId = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->paymentMethodId = session()->has('saved_payment_method_id') ? session()->get('saved_payment_method_id') : '';
        $this->emit('update_cart');
    }

    // Lifecycle Hooks updated (UserAddressId)
    public function updatedUserAddressId()
    {
        session()->forget('saved_user_address_id');
        session()->forget('saved_shipping_company_id');
        session()->forget('shipping');
        session()->put('saved_user_address_id', $this->userAddressId);

        $this->userAddressId = session()->has('saved_user_address_id') ? session()->get('saved_user_address_id') : '';
        $this->shippingCompanyId = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->paymentMethodId = session()->has('saved_payment_method_id') ? session()->get('saved_payment_method_id') : '';
        $this->emit('update_cart');
    }

    public function storeShippingCost()
    {

        // dd($this->shippingCompanies);
        // dd($this->shippingCompanyId); //id da tranp do array
        // $shippingCompany = ShippingCompany::whereId($this->shippingCompanyId)->first();

        // Dentro de uma função ou método onde você deseja fazer essa atribuição
        foreach ($this->shippingCompanies as $index => $company) {
            if ($company['idTransp'] == $this->shippingCompanyId) {
                $this->transp = $company;
                break; // Uma vez encontrado, podemos sair do loop
            }
            $this->transp = null;
        }
        $this->nameShipping = $company['transp_nome'];
         $this->idShipping = $company['idTransp'];
        $this->modelShipping = "Entrega Normal";

        if ($this->transp == null) {
            foreach ($this->shippingCompanies as $index => $company) {
                if (isset($company['pontosRetira'])) {
                    foreach ($company['pontosRetira'] as $pontoRetirada) {
                        if ($pontoRetirada['id'] == $this->shippingCompanyId) {
                            $this->transp = $company;
                            $this->shippingCompanyDetails = $pontoRetirada;
                            $this->nameShipping = $this->shippingCompanyDetails['nome'];
                             $this->idShipping = $this->shippingCompanyDetails['id'];
                            $this->modelShipping = "Retirada";

                        }
                    }
                }
            }
        }
        //   dd($this->idShipping);

        
        session()->put('shipping', [
            'code' => $this->transp['idTransp'],
            'cost' => $this->transp['vlrFrete'],
            'nameShipping' => $this->nameShipping,
            'idShipping' => $this->idShipping,
            'modelShipping' => $this->modelShipping,

        ]);

        $this->emit('update_cart');
    }

    // Lifecycle Hooks updating (ShippingCompanyId)
    public function updatingShippingCompanyId()
    {
        session()->forget('saved_shipping_company_id');
        session()->put('saved_shipping_company_id', $this->shippingCompanyId);
        $this->userAddressId = session()->has('saved_user_address_id') ? session()->get('saved_user_address_id') : '';
        $this->shippingCompanyId = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->emit('update_cart');
    }

    // Lifecycle Hooks updated (ShippingCompanyId)
    public function updatedShippingCompanyId()
    {
        session()->forget('saved_shipping_company_id');
        session()->put('saved_shipping_company_id', $this->shippingCompanyId);
        $this->userAddressId = session()->has('saved_user_address_id') ? session()->get('saved_user_address_id') : '';
        $this->shippingCompanyId = session()->has('saved_shipping_company_id') ? session()->get('saved_shipping_company_id') : '';
        $this->emit('update_cart');
    }

    public function getPaymentMethod()
    {
        $paymentMethod = PaymentMethod::whereId($this->paymentMethodId)->first();
        $this->paymentMethodCode = $paymentMethod->code;
    }

    public function render()
    {
        return view('livewire.frontend.checkout.checkout-component');
    }
}
