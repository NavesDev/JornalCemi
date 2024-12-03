class Row {
    static AllRows = [];
    static currentId = 0;
    static currentOrder = 0;
    //os tipos são (1 = titulo 2 = subtitulo 3 = paragrafo)
    constructor(type = 3, candestroy = true, canreorder = true) {
        this.type = type
        this.id = ++Row.currentId
        this.obj = Row.newObj(type, this.id, candestroy, canreorder);
        this.editorFuncs(candestroy, canreorder)
 
        Row.AllRows.push(this)
    }
    objChange(newType) {
        const ownType = this.type;
        let lastValue = ""
        let lastObj = this.obj.querySelector(".inputValue")
        if (ownType == 3) {
            lastValue = lastObj.innerText;
        } else if (ownType == 1 || ownType == 2) {
            lastValue = lastObj.value;
        } else {
            lastValue = null
        }
        let el = null;
        if (newType == 3) {
            this.type = newType
            el = document.createElement("textarea")
            el.className = "parag inputValue"
            el.innerText = lastValue
            el.placeholder = "Novo paragrafo"
            el.addEventListener('input', (ev) => {
                ev.target.style.height = 'auto';
                ev.target.style.height = ev.target.scrollHeight + 'px';
            });
        } else if (newType == 2) {
            this.type = newType
            el = document.createElement("input")
            el.className = "subtitulo inputValue"
            el.value = lastValue
            el.placeholder = "Novo subtítulo"
        } else if (newType == 1) {
            this.type = newType
            el = document.createElement("input")
            el.className = "titulo inputValue"
            el.value = lastValue
            el.placeholder = "Novo título"

        }

        if (el) {
            this.obj.querySelector(".inputValue").replaceWith(el)
            this.type = newType
        }
    }

    static newObj(type, order) {
        let el = null;
        let clone = document.getElementById("pubI-contTemplate").cloneNode(true);
        clone.id = ""
        clone.setAttribute("data-order", String(order));
        clone = document.getElementById("editing").appendChild(clone)
        if (type == 1) {
            el = document.createElement("input")
            el.className = "titulo inputValue"
            el.placeholder = "Novo título"
        } else if (type == 2) {
            el = document.createElement("input")
            el.className = "subtitulo inputValue"
            el.placeholder = "Novo subtítulo"
        } else if (type == 3) {
            el = document.createElement("textarea")
            el.className = "parag inputValue"
            el.placeholder = "Novo paragrafo"
            el.addEventListener('input', (ev) => {
                ev.target.style.height = 'auto';
                ev.target.style.height = ev.target.scrollHeight + 'px';
            });
        }

        if (el) {
            clone.querySelector("#obj-content").appendChild(el)
        }
        return clone;
    }

    static reorder() {
        // Pega todos os elementos com a classe "needOrder"

        const container = document.querySelector("#editing");
        const items = Array.from(container.getElementsByClassName("needOrder"));

        // Ordena os elementos com base no atributo 'data-order', garantindo que seja comparado numericamente
        items.sort((a, b) => {
            return Number(a.getAttribute("data-order")) - Number(b.getAttribute("data-order"));
        });

        // Reanexa os elementos ao contêiner na nova ordem
        items.forEach(item => {
            container.appendChild(item);
        });
    }
    editorFuncs(candestroy, canreorder) {
        const myobj = this.obj
        const cd = myobj.querySelector(".floatingMenu")
        cd.querySelector("#sectypes").value = this.type
        cd.querySelector("#sectypes").addEventListener("change", (ev) => {
            const vc = ev.target.value
            if (vc != this.type) {
                this.objChange(vc, myobj.getAttribute("data-order"))
            }
        })
        if (candestroy) {
            cd.querySelector("#secDestroy").addEventListener("click", () => {
                this.destroy()
            })
        } else {
            cd.removeChild(cd.querySelector("#secDestroy"))
        }
        if (canreorder) {
            cd.querySelector("#secUp").addEventListener("click", (ev) => {
                let oborder = Number(myobj.getAttribute("data-order"));

                // Verifique se o item pode ser movido para cima
                if (oborder > 2) {
                    // Encontre o item acima (elemento anterior)
                    //const lastob = document.getElementById("editing").querySelector(`[data-order="${oborder - 1}"]`);
                    const allRows = document.getElementById("editing").querySelectorAll("[data-order]")
                    let tradeValue = false
                    let lastValues = []
                    for (const el of allRows) {
                        const orderV = Number(el.getAttribute("data-order"))
                        if (orderV < oborder) {
                            if (lastValues) {
                                let trueNumber = true
                                for (const i of lastValues) {
                                    if (Number(i.getAttribute("data-order")) > orderV) {
                                        trueNumber = false
                                    }
                                }
                                if (trueNumber) {
                                    tradeValue = el
                                    lastValues.push(el)
                                }
                            } else {
                                tradeValue = el
                                lastValues.push(el)
                            }
                        }
                    }
                    // Se o item acima existe, troque a ordem
                    if (tradeValue) {
                        // Troca de ordem: Ajusta os `data-order` de ambos os elementos
                        myobj.setAttribute("data-order", String(tradeValue.getAttribute("data-order")));
                        tradeValue.setAttribute("data-order", String(oborder));
                        
                        // Reorganiza os elementos na DOM
                        Row.reorder();
                    }
                }
            });

            cd.querySelector("#secDown").addEventListener("click", (ev) => {
                let oborder = Number(myobj.getAttribute("data-order"));

                // Verifique se o item pode ser movido para baixo
                if (oborder < Row.currentId) {
                    // Encontre o item abaixo (elemento posterior)
                    const allRows = document.getElementById("editing").querySelectorAll("[data-order]")
                    let tradeValue = false
                    let lastValues = []
                    for (const el of allRows) {
                        const orderV = Number(el.getAttribute("data-order"))
                        if (orderV > oborder) {
                            if (lastValues) {
                                let trueNumber = true
                                for (const i of lastValues) {
                                    if (Number(i.getAttribute("data-order")) < orderV) {
                                        trueNumber = false
                                    }
                                }
                                if (trueNumber) {
                                    tradeValue = el
                                    lastValues.push(el)
                                }
                            } else {
                                tradeValue = el
                                lastValues.push(el)
                            }
                        }
                    }


                    // Se o item abaixo existe, troque a ordem
                    if (tradeValue) {
                        // Troca de ordem: Ajusta os `data-order` de ambos os elementos
                        myobj.setAttribute("data-order", String(tradeValue.getAttribute("data-order")));
                        tradeValue.setAttribute("data-order", String(oborder));
                        

                        // Reorganiza os elementos na DOM
                        Row.reorder();
                    }
                }
            });

        } else {
            cd.removeChild(cd.querySelector("#secUp"))
            cd.removeChild(cd.querySelector("#secDown"))
        }
        return cd
    }
    destroy() {
        if (this.obj) {
            this.obj.remove();
        }

        this.obj = null
    }
}
const basetit = new Row(1, false, false);
const basesub = new Row(2)
const basep = new Row(3)
new Row(3)
document.getElementById("addButton").addEventListener("click", () => {
    new Row();
})
const parags = document.getElementsByClassName("parag");

