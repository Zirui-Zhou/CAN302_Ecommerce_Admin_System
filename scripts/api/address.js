async function search_address_by_user_id(user_id) {
    return JSON.parse(await commonPost(
        "api/address/search_user_id.php",
        {
            'user_id': user_id,
        },
        function () {}
    ))
}