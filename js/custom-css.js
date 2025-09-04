const form_tables = {
    table_1: document.querySelector("#table-1"),
    table_2: document.querySelector("#table-2"),
    table_3: document.querySelector("#table-3"),
    table_4: document.querySelector("#table-4"),  // add the fourth table

    menu_1: document.querySelector("#main"),
    menu_2: document.querySelector("#second"),
    menu_3: document.querySelector("#third"),
    menu_4: document.querySelector("#fourth"),  // add the fourth menu

    start() {
        // Add click listeners for all menu items
        this.menu_1.addEventListener("click", () => this.showTable(1));
        this.menu_2.addEventListener("click", () => this.showTable(2));
        this.menu_3.addEventListener("click", () => this.showTable(3));
        this.menu_4.addEventListener("click", () => this.showTable(4));

        // Hide all except the first by default
        this.showTable(1);
    },

    showTable(n) {
        // Hide all tables first
        [this.table_1, this.table_2, this.table_3, this.table_4].forEach(t => t.classList.add("hide"));

        // Show the selected table
        switch(n) {
            case 1: this.table_1.classList.remove("hide"); break;
            case 2: this.table_2.classList.remove("hide"); break;
            case 3: this.table_3.classList.remove("hide"); break;
            case 4: this.table_4.classList.remove("hide"); break;
        }
    }
};

document.addEventListener("DOMContentLoaded", () => {
    form_tables.start();
});

