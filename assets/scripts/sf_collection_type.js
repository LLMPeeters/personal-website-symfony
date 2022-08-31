class CollectionForm {
    prototype = null;
	prototypeAttributes = {};
    target = null;
    addButton = null;
    fieldCount = 0;
	clone = null;
	fields = [];
	buttonClassses = [];
	
	// This should be cleaned later
    constructor(target, attribute, buttonClasses) {
        this.prototype = target.getAttribute(attribute);
        this.target = target;
		this.buttonClasses = buttonClasses;
		this.clone = this.initClone();
		this.addButton = this.createAddButton();
		
		if(!target.hasChildNodes()) {
			this.target.insertAdjacentElement(`beforeend`, this.getNewField());
		} else {
			this.getPrototypeAttributes();
			
			for(const field of this.target.querySelectorAll(`:scope > *`)) {
				this.getNewField(field);
			}
		}
		
		this.target.insertAdjacentElement(`afterend`, this.addButton);
		this.target.removeAttribute(attribute);
    }
	
	getPrototypeAttributes() {
		const matches = this.prototype.matchAll(/(?<= )([^=]+)="([^"]+)__name__([^"]*)"/gm);
		
		for(let match = matches.next(); !match.done; match = matches.next()) {
			const name = match.value[1];
			const begin = match.value[2];
			const after = match.value[3];
			
			if(!Array.isArray(this.prototypeAttributes[name])) {
				this.prototypeAttributes[name] = [];
			}
			
			this.prototypeAttributes[name].push([begin, after])
		}
	}
	
	resetEditAttributes(target) {
		const m = this.prototypeAttributes;
		const elements = [target];
		
		for(const element of elements) {
			for(const child of element.querySelectorAll(`:scope > *`)) {
				elements.push(child);
			}
			
			for(const attributeName in m) {
				const subArray = m[attributeName];
				const oldValue = element.getAttribute(attributeName);
				
				if(element.hasAttribute(attributeName)) {
					for(const subSubArray of subArray) {
						const begin = subSubArray[0];
						const end = subSubArray[1];
						
						if(oldValue.startsWith(begin) && oldValue.endsWith(end)) {
							element.setAttribute(attributeName, `${begin}__name__${end}`);
							element.setAttribute(`old.${attributeName}`, `${begin}__name__${end}`);
						}
					}
				}
			}
		}
	}
	
	initClone() {
		this.target.insertAdjacentHTML(`afterbegin`, this.prototype);
		
		const field = this.target.querySelector(`:scope > *:first-child`);
		const elements = [field];
		
		for(const item of elements) {
			for(const child of item.querySelectorAll(`:scope > *`)) {
				elements.push(child);
			}
			
			const attributeNames = item.getAttributeNames();
			
			for(const name of attributeNames) {
				if(item.getAttribute(name).includes(`__name__`)) {
					item.setAttribute(
						`old.${name}`,
						item.getAttribute(name)
					)
				}
			}
		}
		
		field.remove();
		
		return field;
	}
	
	createMoveButtons(targetToMove) {
		const upButton = document.createElement(`button`);
		const downButton = document.createElement(`button`);
		const target = targetToMove;
		const thisHelper = this;
		
		upButton.innerText = `up`;
		downButton.innerText = `down`;
		
		for(const className of this.buttonClasses) {
			upButton.classList.add(className);
			downButton.classList.add(className);
		}
		
		upButton.addEventListener(`click`, function(e) {
			e.preventDefault();
			
			const children = Array.from(target.parentNode.querySelectorAll(`:scope > *`));
			const index = children.indexOf(target);
			
			if(index > 0) {
				children[index-1].insertAdjacentElement(`beforebegin`, target);
				thisHelper.resetIndexes();
			}
		});
		
		downButton.addEventListener(`click`, function(e) {
			e.preventDefault();
			
			const children = Array.from(target.parentNode.querySelectorAll(`:scope > *`));
			const index = children.indexOf(target);
			
			if(index < children.length-1) {
				children[index+1].insertAdjacentElement(`afterend`, target);
				thisHelper.resetIndexes();
			}
		});
		
		return [upButton, downButton];
	}
	
	getNewField(inputField = null) {
		const field = inputField ?? this.clone.cloneNode(true);
		const removeButton = this.createRemoveButton(field);
		const moveButtons = this.createMoveButtons(field);
		
		for(const button of moveButtons) {
			field.insertAdjacentElement(`beforeend`, button);
		}
		
		if(inputField !== null) {
			this.resetEditAttributes(inputField);
		}
		
		this.setIndex(field);
		
		field.insertAdjacentElement(`beforeend`, removeButton);
		this.fields.push(field);
		
		return field;
	}
	
	initFirstField(field) {
		const elements = [field];
		
		for(const item of elements) {
			for(const child of item.querySelectorAll(`:scope > *`)) {
				elements.push(child);
			}
			
			const attributeNames = item.getAttributeNames();
			
			for(const name of attributeNames) {
				if(item.getAttribute(name).includes(`__name__`)) {
					item.setAttribute(
						`old.${name}`,
						item.getAttribute(name)
					)
				}
			}
		}
		
		this.clone = field.cloneNode(true);
		
		this.getNewField(field);
	}
	
	createAddButton() {
		const addButton = document.createElement(`button`);
		const target = this.target;
		const thisHelper = this;
		
		for(const className of this.buttonClasses) {
			addButton.classList.add(className);
		}
		
		addButton.innerText = `add`;
		addButton.addEventListener(`click`, function(e) {
			e.preventDefault();
			
			const newField = thisHelper.getNewField();
			
			target.insertAdjacentElement(`beforeend`, newField);
		});
		
		return addButton;
	}
	
	createRemoveButton(targetToRemove) {
		const removeButton = document.createElement(`button`);
		const target = targetToRemove;
		
		for(const className of this.buttonClasses) {
			removeButton.classList.add(className);
		}
		
		removeButton.innerText = `remove`;
		removeButton.addEventListener(`click`, function(e) {
			e.preventDefault();
			
			target.remove();
		});
		
		return removeButton;
	}
	
	resetIndexes() {
		const fields = this.fields[0].parentNode.querySelectorAll(`:scope > *`);
		
		this.fieldCount = 0;
		
		for(const field of fields) {
			this.setIndex(field, true);
		}
	}

    setIndex(element, reset = null) {
		const elements = [element];
		
		for(const item of elements) {
			for(const child of item.querySelectorAll(`:scope > *`)) {
				elements.push(child);
			}
			
			const attributeNames = item.getAttributeNames();
			
			for(const name of attributeNames) {
				if(reset) {
					const oldName = `old.${name}`;
					const oldValue = item.getAttribute(oldName);
					
					if(oldValue) {
						item.setAttribute(name, oldValue);
					}
				}
				
				if(name.slice(0, 4) !== `old.` && item.getAttribute(name).includes(`__name__`)) {
					item.setAttribute(
						name,
						item.getAttribute(name).replaceAll(`__name__`, this.fieldCount)
					);
				}
			}
		}
        
		this.fieldCount++;
		
        return element;
    }
}

const FormManager = {
    forms: [],

    init(options) {
        const collectionForms = document.querySelectorAll(`[${options.targetAttribute}]`);

        for(const form of collectionForms) {
            this.forms.push(
                new CollectionForm(form, options.targetAttribute, options.buttonClasses)
            );
        }
    }
};

FormManager.init({
    targetAttribute: `data-prototype`,
	buttonClasses: [`btn`, `btn-outline-secondary`],
});