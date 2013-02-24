CREATE TABLE paraformal.equipe_registros_atividades (
       id SERIAL NOT NULL
     , pessoa_id INTEGER
     , entrada_saida CHAR(1)
     , data_hora TIMESTAMP DEFAULT now()
     , atividade TEXT
     , remote_addr CIDR
     , x_forwoard CIDR
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_equipe_registros_atividades_1 FOREIGN KEY (pessoa_id)
                  REFERENCES public.pessoas (id)
);

