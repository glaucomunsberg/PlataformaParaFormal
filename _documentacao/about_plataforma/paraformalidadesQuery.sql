select * from public.paraformalidades as p 
    join public.grupos_atividades as ga on p.grupo_atividade_id = ga.id
    join public.pessoas as pes on p.colaborador_pessoa_id = pes.id
    join public.tipos_registros_atividades as tr on p.tipo_registro_atividade_id = tr.id
    join public.tipos_locais as tl on p.tipo_local_id = tl.id
    join public.tipos_condicoes_ambientais as tca on p.tipo_condicao_ambiental_id = tca.id
    join public.tipos_elementos_situacoes as tes on p.tipo_elemento_situacao_id = tes.id
    join public.tipos_pontes as tp on p.tipo_ponte_id = tp.id
    join public.uploads as up on p.imagem_id = up.id
    where p.esta_ativo = 'S'
    and ga.id = 1
