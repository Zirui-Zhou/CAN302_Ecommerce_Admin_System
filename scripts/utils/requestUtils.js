async function commonPost(url, data, func) {
    let result = {
        code: null,
        msg: null,
        data: null
    }

    await $.ajax({
        url: url,
        type: "POST",
        data: JSON.stringify(data),
    })
        .done((res) => {
                func(res)
                result = res
        })
        .fail(function(res) {
            alert(res);
        });
    return result
}