var KTPermissions = function () {
    var permissions = function () {

        $(async function () {
            var checkedItems = [];
            var checked = [];
            var active = [];

            function getValueAtIndex(index) {
                var str = window.location.href;
                return str.split("/")[index];
            }

            var id = getValueAtIndex(4);

            KTApp.block('.form-permissoes', {
                type: 'v2',
                state: 'primary',
                message: "Carregando permissões..."
            })

            await $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/permissoes/perfil/" + id,
                success: function (permited) {
                    return active = permited;
                }
            });

            let menu = []

            await $.ajax({
                type: "GET",
                dataType: 'json',
                url: "/permissoes/modulos",
                success: function (data) {
                    menu = data.map(type => ({
                        id: type.id,
                        ids: type.id,
                        name: type.name,
                        text: type.name,
                        items: type.permission_menu.map(menu => {
                            menu.id = menu.module_id + '.' + menu.id
                            menu.ids = menu.id
                            menu.items = menu.permission_submenu
                            menu.name = menu.name
                            menu.text = menu.name
                            menu.brewery_type = menu.name
                            menu.expanded = true,
                                menu.items.map(submenu => {
                                    submenu.ids = submenu.id
                                    submenu.brewery_type = submenu.name
                                    submenu.name = submenu.name
                                    submenu.text = submenu.name
                                    submenu.id = type.id + '.' + submenu.menu_id + '.' + submenu.id
                                })
                            return menu
                        })
                    }));

                    KTApp.unblock('.form-permissoes')
                }
            });

            function isProduct(data) {
                return !data.items.length;
            }

            function processProduct(product) {
                var itemIndex = -1;

                $.each(checkedItems, function (index, item) {
                    if (item.key === product.key) {
                        itemIndex = index;
                        return false;
                    }
                });

                if (product.selected && itemIndex === -1) {
                    checkedItems.push(product);
                } else if (!product.selected) {
                    checkedItems.splice(itemIndex, 1);
                }
            }
            checked = checkedItems;

            $("#selection-treeview").dxTreeView({
                items: menu,
                width: 320,
                showCheckBoxesMode: "normal",
                onItemSelectionChanged: function (e) {
                    var item = e.node;

                    if (isProduct(item)) {
                        processProduct($.extend({
                            category: item.parent.text
                        }, item))
                    } else {
                        $.each(item.items, function (index, product) {
                            processProduct($.extend({
                                category: item.text
                            }, product))

                            $.each(product.items, function (index, submenu) {
                                processProduct($.extend({
                                    category: product.text
                                }, submenu))
                            });
                        });
                    }
                }
            });

            active.filter(it => !it.sub_menu_id).map(it => {
                $("#selection-treeview").dxTreeView('selectItem', `${it.module_id}.${it.menu_id}`)
            })
            active.filter(it => it.sub_menu_id).map(it => {
                $("#selection-treeview").dxTreeView('selectItem', `${it.module_id}.${it.menu_id}.${it.sub_menu_id}`)
            })

            function salvarPermissao() {
                var data = checked;
                let id = getValueAtIndex(4);
                let arr = []

                data.forEach(function (el, i) {
                    arr.push({
                        module_id: el.key.toString().split('.')[0],
                        menu_id: el.key.toString().split('.')[1],
                        sub_menu_id: el.key.toString().split('.')[2] != null ? el.key.toString().split('.')[2] : null,
                        profile_id: id
                    })
                })

                if (data.length == 0) {
                    arr.push({
                        profile_id: id
                    })
                }

                $.ajax({
                    type: "POST",
                    url: '/permissoes',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    data: JSON.stringify(arr),
                    success: function (response) {
                        toastr.success(response.message.message)
                        setTimeout(function () {
                            location.reload(true)
                        }, 1500)
                    }
                });

            }

            $('#salvar_permissoes').on('click', function () {
                salvarPermissao()
            })
        })
    }

    return {
        init: function () {
            permissions()
        },
    };
}()
