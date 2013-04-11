CREATE TABLE paraformal.denuncias (
       id SERIAL NOT NULL
     , pessoa_nome VARCHAR(255)
     , pessoa_email VARCHAR(255)
     , denuncia TEXT
     , link VARCHAR(300)
     , remote_addr CIDR
     , revisor_id INTEGER
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
);

