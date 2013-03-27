CREATE TABLE paraformal.colaboradores_paraformalidades (
       id SERIAL NOT NULL
     , pessoa_id INTEGER
     , imagem_paraformal_id INTEGER
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_colaboradores_paraformalidades_2 FOREIGN KEY (pessoa_id)
                  REFERENCES public.pessoas (id)
     , CONSTRAINT FK_colaboradores_paraformalidades_3 FOREIGN KEY (imagem_paraformal_id)
                  REFERENCES paraformal.imagens_paraformalidades (id)
);

