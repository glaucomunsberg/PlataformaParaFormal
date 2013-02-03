CREATE TABLE paraformal.equipe_grupos_atividade (
       id SERIAL
     , pessoa_id INTEGER
     , grupo_atividade_id INTEGER
     , coordenador CHAR(1) DEFAULT 'N'
     , dt_cadastro TIMESTAMP DEFAULT now()
     , CONSTRAINT FK_colaboradores_grupos_atividade_2 FOREIGN KEY (pessoa_id)
                  REFERENCES public.pessoas (id)
     , CONSTRAINT FK_colaboradores_grupos_atividade_3 FOREIGN KEY (grupo_atividade_id)
                  REFERENCES paraformal.grupos_atividades (id)
);

