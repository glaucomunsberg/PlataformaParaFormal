CREATE TABLE paraformal.equipe_grupos_atividade (
       id SERIAL NOT NULL
     , pessoa_id INTEGER
     , grupo_atividade_id INTEGER
     , participacao_equipe_id INTEGER
     , dt_cadastro TIMESTAMP DEFAULT now()
     , PRIMARY KEY (id)
     , CONSTRAINT FK_colaboradores_grupos_atividade_2 FOREIGN KEY (pessoa_id)
                  REFERENCES public.pessoas (id)
     , CONSTRAINT FK_colaboradores_grupos_atividade_3 FOREIGN KEY (grupo_atividade_id)
                  REFERENCES paraformal.grupos_atividades (id)
     , CONSTRAINT FK_equipe_grupos_atividade_3 FOREIGN KEY (participacao_equipe_id)
                  REFERENCES paraformal.participacoes_equipe (id)
);

