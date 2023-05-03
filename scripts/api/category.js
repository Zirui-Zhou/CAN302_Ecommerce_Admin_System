async function update_category(id, name, desc) {
    await commonPost(
        "api/category/update.php",
        {
            'id': id,
            'name': name,
            'desc': desc
        },
        function (res) {
            alert(res)
        }
    )
}

async function delete_category(id) {
    await commonPost(
        "api/category/delete.php",
        {
            'id': id,
        },
        function (res) {
            alert(res)
        }
    )
}

async function add_category(name, desc) {
    await commonPost(
        "api/category/add.php",
        {
            'name': name,
            'desc': desc
        },
        function (res) {
            alert(res)
        }
    )
}