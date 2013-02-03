CREATE TABLE paraformal.equipamento_portes (
       id SERIAL NOT NULL
     , descricao VARCHAR(255)
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
);

