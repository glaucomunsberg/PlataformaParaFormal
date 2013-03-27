CREATE TABLE paraformal.imagens_paraformalidades (
       id SERIAL NOT NULL
     , cena_id INTEGER
     , upload_id INTEGER
     , descricao VARCHAR(255)
     , geo_latitude VARCHAR(30)
     , geo_longitude VARCHAR(30)
     , link VARCHAR(255)
     , turno_ocorrencia_id INTEGER
     , atividade_registrada_id INTEGER
     , quantidade_registrada_id INTEGER
     , espaco_localizacao_id INTEGER
     , corpo_numero_id INTEGER
     , corpo_posicao_id INTEGER
     , equipamento_porte_id INTEGER
     , equipamento_mobilidade_id INTEGER
     , dt_ocorrencia DATE
     , estaAtiva CHAR(1) DEFAULT 'S'
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_imagens_paraformalidades_4 FOREIGN KEY (atividade_registrada_id)
                  REFERENCES paraformal.atividades_registradas (id)
     , CONSTRAINT FK_imagens_paraformalidades_6 FOREIGN KEY (equipamento_porte_id)
                  REFERENCES paraformal.equipamento_portes (id)
     , CONSTRAINT FK_imagens_paraformalidades_7 FOREIGN KEY (equipamento_mobilidade_id)
                  REFERENCES paraformal.equipamento_mobilidades (id)
     , CONSTRAINT FK_imagens_paraformalidades_8 FOREIGN KEY (corpo_numero_id)
                  REFERENCES paraformal.corpo_numeros (id)
     , CONSTRAINT FK_imagens_paraformalidades_9 FOREIGN KEY (corpo_posicao_id)
                  REFERENCES paraformal.corpo_posicoes (id)
     , CONSTRAINT FK_imagens_paraformalidades_10 FOREIGN KEY (quantidade_registrada_id)
                  REFERENCES paraformal.quantidades_registrada (id)
     , CONSTRAINT FK_imagens_paraformais_2 FOREIGN KEY (upload_id)
                  REFERENCES public.uploads (id)
     , CONSTRAINT FK_imagens_paraformalidades_12 FOREIGN KEY (turno_ocorrencia_id)
                  REFERENCES paraformal.turnos_ocorrencia (id)
     , CONSTRAINT FK_imagens_paraformalidades_11 FOREIGN KEY (cena_id)
                  REFERENCES paraformal.cenas (id)
     , CONSTRAINT FK_imagens_paraformalidades_13 FOREIGN KEY (espaco_localizacao_id)
                  REFERENCES paraformal.espaco_localizacoes (id)
);

