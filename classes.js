class connectionMessage {
    constructor(userId, name, mail, img) {
        this.userId = userId;
        this.name = name;
        this.mail = mail;
        this.img = img;
        const action = 'connect';
    }
    test() {
        this.action = 'not connect';
    }
}