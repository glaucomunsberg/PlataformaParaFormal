CREATE TABLE paraformal.correcao_paraformalidades (
       id SERIAL NOT NULL
     , paraformalidade_id INTEGER
     , pessoa_nome VARCHAR(255)
     , pessoa_email VARCHAR(255)
     , geo_latitude VARCHAR(30)
     , geo_longitude VARCHAR(30)
     , descricao VARCHAR(255)
     , upload_id INTEGER
     , remote_addr CIDR
     , antiga_latitude CHAR(30)
     , antiga_longitude CHAR(30)
     , antiga_upload_id INTEGER
     , antiga_descricao VARCHAR(255)
     , revisor_id INTEGER
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_correcao_paraformalidades_1 FOREIGN KEY (paraformalidade_id)
                  REFERENCES paraformal.paraformalidades (id)
);

