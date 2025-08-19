<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Checkout</title>
</head>
<body>
    <h1>Buy Test Product - $5.00</h1>
    <button id="checkout-button">Checkout</button>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ config('services.stripe.key') }}");
        document.getElementById('checkout-button').addEventListener('click', async () => {
            const resp = await fetch('/checkout/session', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
            const data = await resp.json();
            if (data.id) {
                const { error } = await stripe.redirectToCheckout({ sessionId: data.id });
                if (error) {
                    alert(error.message);
                }
            } else {
                alert('Could not create session');
            }
        });
    </script>
</body>
</html>
