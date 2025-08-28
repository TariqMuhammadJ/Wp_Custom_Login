//over here we will run css objects from classes and recreate as we need them
// by extracting all the class instances using class_properties or get_class_variables etc from php
// dynamically change the object and send them back
// this will help alot when it comes to modifying code
// the class-options.php
// create a submenu 


const form_tables = {
    table_1: document.querySelector("#table-1"),
    table_2: document.querySelector("#table-2"),
    table_3: document.querySelector("#table-3"),
    menu_1: document.querySelector("#main"),
    menu_2: document.querySelector("#second"),
    menu_3:document.querySelector("#third"),
    start() {
        this.menu_1.addEventListener("click", () => this.hide1());
        this.menu_2.addEventListener("click", () => this.hide2());
        this.menu_3.addEventListener("click", () => this.hide3());  
        this.table_2.classList.add("hide");
        this.table_3.classList.add("hide");
    },

    hide2(){
         this.table_3.classList.add("hide");
         this.table_1.classList.add("hide");
         this.table_2.classList.remove("hide");
    },

    hide1(){
        this.table_1.classList.remove("hide");
        this.table_2.classList.add("hide");
        this.table_3.classList.add("hide");
    },

    hide3(){
        this.table_1.classList.add("hide");
        this.table_2.classList.add("hide");
        this.table_3.classList.remove("hide");
    }

    

    
};

document.addEventListener("DOMContentLoaded", () => {
    form_tables.start();
})


