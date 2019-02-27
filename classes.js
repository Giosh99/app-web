class connectionMessage {
    constructor(userId, name, mail, img) {
        this.userId = userId;
        this.name = name;
        this.mail = mail;
        this.img = img;
        const action = 'connect';
    }
}

class destinationMessage {
    constructor(userId, to) {
        this.userId = userId;
        const connection ="to";
        this.to = to;
    }
}

class message {
    constructor(userId, text, to) {
        this.userId = userId;
        this.text = text;
        this.to = to;
        const action = "message";
        this.type = "message";
        this.load = "client";
    }
}