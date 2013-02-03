CREATE TABLE paraformal.grupos_atividades (
       id SERIAL NOT NULL
     , cidade_id INTEGER
     , descricao VARCHAR(400)
     , geocode_origem_latitude VARCHAR(30)
     , geocode_origem_longitude VARCHAR(30)
     , geocode_destino_latitude VARCHAR(30)
     , geocode_destino_longitude VARCHAR(30)
     , dt_ocorrencia DATE
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_grupos_atividades_1 FOREIGN KEY (cidade_id)
                  REFERENCES public.cidades (id)
);

