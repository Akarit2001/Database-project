
CREATE TABLE customer (
    cid	INT(4) NOT NULL AUTO_INCREMENT,
    cfname VARCHAR(255),
    clname VARCHAR(255),
    cphone VARCHAR(255),
    caddress VARCHAR(255),
    CONSTRAINT PK_cus PRIMARY KEY (cid)
);

CREATE TABLE seller(
    sid INT(4) NOT NULL AUTO_INCREMENT,
    sfname VARCHAR(255),
    slname VARCHAR(255),
    sphone VARCHAR(255),
    saddress VARCHAR(255),
    pass	varchar(255),
    CONSTRAINT PK_sell PRIMARY KEY (sid)
);

CREATE TABLE product(
    sid INT(4),
    pid INT(4) NOT NULL AUTO_INCREMENT,
    pname VARCHAR(255),
    pprice INT(4),
    pamout INT(4),
    CONSTRAINT PK_pro PRIMARY KEY (pid),
    CONSTRAINT FK_seller FOREIGN KEY (sid)
        REFERENCES seller(sid)
);
CREATE TABLE Addproduct(
    sid INT(4),
    aid INT(4) NOT NULL AUTO_INCREMENT,
    pid INT(4),
    addAmout INT(4),
    CONSTRAINT PK_add PRIMARY KEY (aid),
    CONSTRAINT FK_sell_add FOREIGN KEY (sid)
        REFERENCES seller(sid),
    CONSTRAINT FK_pro_add FOREIGN KEY (pid)
        REFERENCES product(pid)
);



CREATE TABLE bill(
    bid INT(4),
    cid INT(4),
    pid INT(4),
    bamout INT(4),
    CONSTRAINT PK_bill PRIMARY KEY (bid,cid,pid),
    CONSTRAINT FK_bill_cus FOREIGN KEY (cid)
        REFERENCES customer(cid),
    CONSTRAINT FK_bill_pro FOREIGN KEY (pid)
        REFERENCES product(pid)
);

