@extends('layouts.app')

@section('page_title')
    {{ 'Donate' }}
@endsection

@section('content')
    <main class="donate-main">
        <section class="donate-section">
            <h2>Donate to Pawfect Pawtrails</h2>
            <p class="cp">Your donation goes a long way in supporting our mission to find loving homes for rescue
                pets and provide resources for pet owners. Thank you for your generosity!</p>
            <div class="donation-options">
                <div class="donation-option">
                    <h3><img src="images/paypal-logo.png" alt="PayPal"><span>pawfectpawtrails@paypal</span></h3>
                </div>
                <div class="donation-option d2">
                    <h3><img src="images/upi-logo.svg" alt="UPI Logo"><span>pawfectpawtrails@okhdfc</span></h3>
                </div>
            </div>
            <div class="net-banking-option">
                <div class="net-banking-header">
                    <h3><img src="images/net-banking-logo.png" alt="Net Banking Logo">Net Banking</h3>
                </div>
                <p class="bank-info bi">Donate using your bank's net banking service.</p>
                <div class="bank-info-container">
                    <p class="bank-info">Account Holder Name: Pawfect Pawtrails<br>Account Number: 1234 5678
                        0910<br>IFSC Code: HDFC0000001</p>
                </div>
            </div>
        </section>
    </main>
@endsection
