
document.querySelector(".catalog_list").addEventListener("click", function(e){
    if(!e.target.hasAttribute("delete_elem")){
        return
    };
    let product_item = e.target.closest(".catalog_item");
    let product_id = product_item.getAttribute("product_id");
    if(confirm("Действительно удалить элемент?")){
        fetch("/catalog/rest/product/delete/"+ product_id +"/")
            .then( result => result.json() )
            .then( product => {
                if (product){
                    product_item.remove();
                    alert("Товар успешно удален!");
                }
            })
    }    
})