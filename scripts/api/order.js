async function add_product(order_id, number, product_id) {
    return JSON.parse(await commonPost(
        "api/order/add_product.php",
        {
            'order_id': order_id,
            'number': number,
            'product_id': product_id,
        },
        function () {}
    ))
}

async function get_product_list(id) {
    return JSON.parse(await commonPost(
        "api/order/get_product_list.php",
        {
            'id': id,
        },
        function () {}
    ))
}

async function delete_product(id) {
    return await commonPost(
        "api/order/delete_product.php",
        {
            'id': id,
        },
        function () {}
    )
}

async function update_order(id, state, time, remark, user_id, address_id, payment_id, amount) {
    return await commonPost(
        "api/order/update.php",
        {
            id: id,
            state: state,
            time: time,
            remark: remark,
            user_id: user_id,
            address_id: address_id,
            payment_id: payment_id,
            amount: amount,
        },
        function () {}
    )
}
