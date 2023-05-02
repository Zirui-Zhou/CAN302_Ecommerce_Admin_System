async function search_payment_by_user_id(user_id) {
    return JSON.parse(await commonPost(
        "api/payment/search_user_id.php",
        {
            'user_id': user_id,
        },
        function () {}
    ))
}