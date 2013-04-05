--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: paraformal; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA paraformal;


ALTER SCHEMA paraformal OWNER TO postgres;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: lo; Type: DOMAIN; Schema: public; Owner: postgres
--

CREATE DOMAIN lo AS oid;


ALTER DOMAIN public.lo OWNER TO postgres;

--
-- Name: fnc_get_parametro(character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION fnc_get_parametro(nome character varying) RETURNS character varying
    LANGUAGE plpgsql
    AS $_$
	DECLARE
		v_nome_parametro ALIAS FOR $1;
		r record;
	BEGIN
		select into r p.* from parametros as p where p.nome = v_nome_parametro;
		
		RETURN r.valor;
	END
$_$;


ALTER FUNCTION public.fnc_get_parametro(nome character varying) OWNER TO postgres;

--
-- Name: retira_acento(text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION retira_acento(text) RETURNS text
    LANGUAGE sql IMMUTABLE STRICT
    AS $_$
select
translate($1,'áàâãäéèêëíìïóòôõöúùûüÁÀÂÃÄÉÈÊËÍÌÏÓÒÔÕÖÚÙÛÜçÇ','aaaaaeeeeiiiooooouuuuAAAAAEEEEIIIOOOOOUUUUcC');
$_$;


ALTER FUNCTION public.retira_acento(text) OWNER TO postgres;

--
-- Name: serialize_array(text[], character varying); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION serialize_array(text[], separador character varying) RETURNS text
    LANGUAGE plpgsql
    AS $_$
	DECLARE
		v_array ALIAS FOR $1;
		v_separador ALIAS FOR $2;
		v_serialize_array text := '';
	BEGIN
		FOR i IN array_lower(v_array, 1) .. array_upper(v_array, 1) LOOP
			IF v_serialize_array = '' THEN
				v_serialize_array := v_array[i];
			ELSE
				IF v_separador = '' THEN
					v_serialize_array := v_serialize_array||','||v_array[i];
				ELSE
					v_serialize_array := v_serialize_array||v_separador||v_array[i];
				END IF;
			END IF;
		END LOOP;

		RETURN v_serialize_array;
	END
$_$;


ALTER FUNCTION public.serialize_array(text[], separador character varying) OWNER TO postgres;

SET search_path = paraformal, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: atividades_registradas; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE atividades_registradas (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.atividades_registradas OWNER TO postgres;

--
-- Name: atividades_registradas_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE atividades_registradas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.atividades_registradas_id_seq OWNER TO postgres;

--
-- Name: atividades_registradas_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE atividades_registradas_id_seq OWNED BY atividades_registradas.id;


--
-- Name: cenas; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE cenas (
    id integer NOT NULL,
    descricao character varying(255),
    grupo_atividade_id integer,
    dt_ocorrencia date DEFAULT now(),
    estaativo character(1) DEFAULT 'S'::bpchar,
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.cenas OWNER TO postgres;

--
-- Name: cenas_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE cenas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.cenas_id_seq OWNER TO postgres;

--
-- Name: cenas_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE cenas_id_seq OWNED BY cenas.id;


--
-- Name: climas; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE climas (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.climas OWNER TO postgres;

--
-- Name: climas_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE climas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.climas_id_seq OWNER TO postgres;

--
-- Name: climas_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE climas_id_seq OWNED BY climas.id;


--
-- Name: climas_paraformalidade; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE climas_paraformalidade (
    id integer NOT NULL,
    clima_id integer,
    paraformalidade_id integer,
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.climas_paraformalidade OWNER TO postgres;

--
-- Name: climas_paraformalidade_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE climas_paraformalidade_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.climas_paraformalidade_id_seq OWNER TO postgres;

--
-- Name: climas_paraformalidade_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE climas_paraformalidade_id_seq OWNED BY climas_paraformalidade.id;


--
-- Name: colaboradores_paraformalidades; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE colaboradores_paraformalidades (
    id integer NOT NULL,
    pessoa_id integer,
    paraformalidade_id integer,
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.colaboradores_paraformalidades OWNER TO postgres;

--
-- Name: colaboradores_paraformalidades_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE colaboradores_paraformalidades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.colaboradores_paraformalidades_id_seq OWNER TO postgres;

--
-- Name: colaboradores_paraformalidades_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE colaboradores_paraformalidades_id_seq OWNED BY colaboradores_paraformalidades.id;


--
-- Name: condicionantes_ambientais; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE condicionantes_ambientais (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.condicionantes_ambientais OWNER TO postgres;

--
-- Name: condicionantes_ambientais_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE condicionantes_ambientais_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.condicionantes_ambientais_id_seq OWNER TO postgres;

--
-- Name: condicionantes_ambientais_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE condicionantes_ambientais_id_seq OWNED BY condicionantes_ambientais.id;


--
-- Name: condicionantes_ambientais_paraformalidade; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE condicionantes_ambientais_paraformalidade (
    id integer NOT NULL,
    condicionante_ambiental_id integer,
    paraformalidade_id integer,
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.condicionantes_ambientais_paraformalidade OWNER TO postgres;

--
-- Name: condicionantes_ambientais_paraformalidade_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE condicionantes_ambientais_paraformalidade_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.condicionantes_ambientais_paraformalidade_id_seq OWNER TO postgres;

--
-- Name: condicionantes_ambientais_paraformalidade_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE condicionantes_ambientais_paraformalidade_id_seq OWNED BY condicionantes_ambientais_paraformalidade.id;


--
-- Name: condicoes_ambientais; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE condicoes_ambientais (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.condicoes_ambientais OWNER TO postgres;

--
-- Name: condicoes_ambientais_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE condicoes_ambientais_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.condicoes_ambientais_id_seq OWNER TO postgres;

--
-- Name: condicoes_ambientais_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE condicoes_ambientais_id_seq OWNED BY condicoes_ambientais.id;


--
-- Name: corpo_numeros; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE corpo_numeros (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.corpo_numeros OWNER TO postgres;

--
-- Name: corpo_numeros_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE corpo_numeros_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.corpo_numeros_id_seq OWNER TO postgres;

--
-- Name: corpo_numeros_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE corpo_numeros_id_seq OWNED BY corpo_numeros.id;


--
-- Name: corpo_posicoes; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE corpo_posicoes (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.corpo_posicoes OWNER TO postgres;

--
-- Name: corpo_posicoes_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE corpo_posicoes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.corpo_posicoes_id_seq OWNER TO postgres;

--
-- Name: corpo_posicoes_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE corpo_posicoes_id_seq OWNED BY corpo_posicoes.id;


--
-- Name: equipamento_instalacoes; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE equipamento_instalacoes (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.equipamento_instalacoes OWNER TO postgres;

--
-- Name: equipamento_instalacoes_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE equipamento_instalacoes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.equipamento_instalacoes_id_seq OWNER TO postgres;

--
-- Name: equipamento_instalacoes_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE equipamento_instalacoes_id_seq OWNED BY equipamento_instalacoes.id;


--
-- Name: equipamento_instalacoes_paraformalidade; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE equipamento_instalacoes_paraformalidade (
    id integer NOT NULL,
    equipamento_instalacao_id integer,
    paraformalidade_id integer,
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.equipamento_instalacoes_paraformalidade OWNER TO postgres;

--
-- Name: equipamento_instalacoes_paraformalidade_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE equipamento_instalacoes_paraformalidade_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.equipamento_instalacoes_paraformalidade_id_seq OWNER TO postgres;

--
-- Name: equipamento_instalacoes_paraformalidade_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE equipamento_instalacoes_paraformalidade_id_seq OWNED BY equipamento_instalacoes_paraformalidade.id;


--
-- Name: equipamento_mobilidades; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE equipamento_mobilidades (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.equipamento_mobilidades OWNER TO postgres;

--
-- Name: equipamento_mobilidades_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE equipamento_mobilidades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.equipamento_mobilidades_id_seq OWNER TO postgres;

--
-- Name: equipamento_mobilidades_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE equipamento_mobilidades_id_seq OWNED BY equipamento_mobilidades.id;


--
-- Name: equipamento_portes; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE equipamento_portes (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.equipamento_portes OWNER TO postgres;

--
-- Name: equipamento_portes_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE equipamento_portes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.equipamento_portes_id_seq OWNER TO postgres;

--
-- Name: equipamento_portes_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE equipamento_portes_id_seq OWNED BY equipamento_portes.id;


--
-- Name: equipe_grupos_atividade; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE equipe_grupos_atividade (
    id integer NOT NULL,
    pessoa_id integer,
    grupo_atividade_id integer,
    participacao_equipe_id integer,
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.equipe_grupos_atividade OWNER TO postgres;

--
-- Name: equipe_grupos_atividade_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE equipe_grupos_atividade_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.equipe_grupos_atividade_id_seq OWNER TO postgres;

--
-- Name: equipe_grupos_atividade_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE equipe_grupos_atividade_id_seq OWNED BY equipe_grupos_atividade.id;


--
-- Name: equipe_registros_atividades; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE equipe_registros_atividades (
    id integer NOT NULL,
    pessoa_id integer,
    entrada_saida character(1),
    data_hora timestamp without time zone DEFAULT now(),
    atividade text,
    remote_addr cidr,
    x_forwoard cidr,
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.equipe_registros_atividades OWNER TO postgres;

--
-- Name: equipe_registros_atividades_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE equipe_registros_atividades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.equipe_registros_atividades_id_seq OWNER TO postgres;

--
-- Name: equipe_registros_atividades_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE equipe_registros_atividades_id_seq OWNED BY equipe_registros_atividades.id;


--
-- Name: espaco_localizacoes; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE espaco_localizacoes (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.espaco_localizacoes OWNER TO postgres;

--
-- Name: espaco_localizacoes_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE espaco_localizacoes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.espaco_localizacoes_id_seq OWNER TO postgres;

--
-- Name: espaco_localizacoes_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE espaco_localizacoes_id_seq OWNED BY espaco_localizacoes.id;


--
-- Name: grupos_atividades; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE grupos_atividades (
    id integer NOT NULL,
    cidade_id integer,
    descricao character varying(400),
    geocode_origem_latitude character varying(30),
    geocode_origem_longitude character varying(30),
    geocode_destino_latitude character varying(30),
    geocode_destino_longitude character varying(30),
    dt_ocorrencia date,
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.grupos_atividades OWNER TO postgres;

--
-- Name: grupos_atividades_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE grupos_atividades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.grupos_atividades_id_seq OWNER TO postgres;

--
-- Name: grupos_atividades_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE grupos_atividades_id_seq OWNED BY grupos_atividades.id;


--
-- Name: paraformalidades; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE paraformalidades (
    id integer NOT NULL,
    cena_id integer,
    upload_id integer,
    descricao character varying(255),
    geo_latitude character varying(30),
    geo_longitude character varying(30),
    link character varying(255),
    turno_ocorrencia_id integer,
    atividade_registrada_id integer,
    quantidade_registrada_id integer,
    espaco_localizacao_id integer,
    corpo_numero_id integer,
    corpo_posicao_id integer,
    equipamento_porte_id integer,
    equipamento_mobilidade_id integer,
    dt_ocorrencia date,
    estaativa character(1) DEFAULT 'S'::bpchar,
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.paraformalidades OWNER TO postgres;

--
-- Name: paraformalidades_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE paraformalidades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.paraformalidades_id_seq OWNER TO postgres;

--
-- Name: paraformalidades_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE paraformalidades_id_seq OWNED BY paraformalidades.id;


--
-- Name: participacoes_equipe; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE participacoes_equipe (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.participacoes_equipe OWNER TO postgres;

--
-- Name: participacoes_equipe_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE participacoes_equipe_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.participacoes_equipe_id_seq OWNER TO postgres;

--
-- Name: participacoes_equipe_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE participacoes_equipe_id_seq OWNED BY participacoes_equipe.id;


--
-- Name: pessoa_procedencias; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE pessoa_procedencias (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.pessoa_procedencias OWNER TO postgres;

--
-- Name: pessoa_procedencias_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE pessoa_procedencias_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.pessoa_procedencias_id_seq OWNER TO postgres;

--
-- Name: pessoa_procedencias_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE pessoa_procedencias_id_seq OWNED BY pessoa_procedencias.id;


--
-- Name: quantidades_registrada; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE quantidades_registrada (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.quantidades_registrada OWNER TO postgres;

--
-- Name: quantidades_registrada_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE quantidades_registrada_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.quantidades_registrada_id_seq OWNER TO postgres;

--
-- Name: quantidades_registrada_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE quantidades_registrada_id_seq OWNED BY quantidades_registrada.id;


--
-- Name: sentidos; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE sentidos (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone
);


ALTER TABLE paraformal.sentidos OWNER TO postgres;

--
-- Name: sentidos_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE sentidos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.sentidos_id_seq OWNER TO postgres;

--
-- Name: sentidos_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE sentidos_id_seq OWNED BY sentidos.id;


--
-- Name: sentidos_paraformalidade; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE sentidos_paraformalidade (
    id integer NOT NULL,
    sentido_id integer,
    paraformalidade_id integer,
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.sentidos_paraformalidade OWNER TO postgres;

--
-- Name: sentidos_paraformalidade_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE sentidos_paraformalidade_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.sentidos_paraformalidade_id_seq OWNER TO postgres;

--
-- Name: sentidos_paraformalidade_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE sentidos_paraformalidade_id_seq OWNED BY sentidos_paraformalidade.id;


--
-- Name: turnos_ocorrencia; Type: TABLE; Schema: paraformal; Owner: postgres; Tablespace: 
--

CREATE TABLE turnos_ocorrencia (
    id integer NOT NULL,
    descricao character varying(255),
    dt_cadastro timestamp without time zone DEFAULT now()
);


ALTER TABLE paraformal.turnos_ocorrencia OWNER TO postgres;

--
-- Name: turnos_ocorrencia_id_seq; Type: SEQUENCE; Schema: paraformal; Owner: postgres
--

CREATE SEQUENCE turnos_ocorrencia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE paraformal.turnos_ocorrencia_id_seq OWNER TO postgres;

--
-- Name: turnos_ocorrencia_id_seq; Type: SEQUENCE OWNED BY; Schema: paraformal; Owner: postgres
--

ALTER SEQUENCE turnos_ocorrencia_id_seq OWNED BY turnos_ocorrencia.id;


SET search_path = public, pg_catalog;

--
-- Name: ci_sessions; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE ci_sessions (
    session_id character varying(40) DEFAULT '0'::character varying NOT NULL,
    ip_address character varying(16) DEFAULT '0'::character varying,
    user_agent character varying(50) NOT NULL,
    last_activity integer DEFAULT 0 NOT NULL,
    user_data text
);


ALTER TABLE public.ci_sessions OWNER TO postgres;

--
-- Name: cidades; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cidades (
    id integer NOT NULL,
    unidade_federativa_id integer,
    nome character varying(255) DEFAULT NULL::character varying,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL,
    geo_latitude character varying(30),
    geo_longitude character varying(30)
);


ALTER TABLE public.cidades OWNER TO postgres;

--
-- Name: cidades_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cidades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cidades_id_seq OWNER TO postgres;

--
-- Name: cidades_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cidades_id_seq OWNED BY cidades.id;


--
-- Name: empresas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE empresas (
    id integer NOT NULL,
    nome character varying(255) DEFAULT NULL::character varying,
    cnpj character varying(15) DEFAULT NULL::character varying,
    dt_cadastro date
);


ALTER TABLE public.empresas OWNER TO postgres;

--
-- Name: empresas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE empresas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.empresas_id_seq OWNER TO postgres;

--
-- Name: empresas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE empresas_id_seq OWNED BY empresas.id;


--
-- Name: empresas_perfis; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE empresas_perfis (
    empresa_id integer,
    perfil_id integer
);


ALTER TABLE public.empresas_perfis OWNER TO postgres;

--
-- Name: enderecos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE enderecos (
    id integer NOT NULL,
    pessoa_id integer,
    endereco_tipo_id integer,
    cidade_id integer,
    cep character varying(20) DEFAULT NULL::character varying,
    rua character varying(255) DEFAULT NULL::character varying,
    numero character varying(10) DEFAULT NULL::character varying,
    bairro character varying(255) DEFAULT NULL::character varying,
    complemento character varying(255) DEFAULT NULL::character varying,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.enderecos OWNER TO postgres;

--
-- Name: enderecos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE enderecos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.enderecos_id_seq OWNER TO postgres;

--
-- Name: enderecos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE enderecos_id_seq OWNED BY enderecos.id;


--
-- Name: enderecos_tipos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE enderecos_tipos (
    id integer NOT NULL,
    descricao character varying(255) DEFAULT NULL::character varying,
    flg_tipo character varying(1) DEFAULT NULL::character varying,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.enderecos_tipos OWNER TO postgres;

--
-- Name: enderecos_tipos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE enderecos_tipos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.enderecos_tipos_id_seq OWNER TO postgres;

--
-- Name: enderecos_tipos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE enderecos_tipos_id_seq OWNED BY enderecos_tipos.id;


--
-- Name: estados_civis; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE estados_civis (
    id integer NOT NULL,
    descricao character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.estados_civis OWNER TO postgres;

--
-- Name: estados_civis_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE estados_civis_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estados_civis_id_seq OWNER TO postgres;

--
-- Name: estados_civis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE estados_civis_id_seq OWNED BY estados_civis.id;


--
-- Name: geocode_cache_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE geocode_cache_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.geocode_cache_seq OWNER TO postgres;

--
-- Name: geocode_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE geocode_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.geocode_id_seq OWNER TO postgres;

--
-- Name: geocode_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE geocode_id_seq OWNED BY cidades.id;


--
-- Name: grupos_acessos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grupos_acessos (
    id integer NOT NULL,
    nome character varying(255) DEFAULT NULL::character varying,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.grupos_acessos OWNER TO postgres;

--
-- Name: grupos_acessos_empresas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grupos_acessos_empresas (
    id integer NOT NULL,
    grupo_acesso_id integer,
    empresa_id integer
);


ALTER TABLE public.grupos_acessos_empresas OWNER TO postgres;

--
-- Name: grupos_acessos_empresas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grupos_acessos_empresas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grupos_acessos_empresas_id_seq OWNER TO postgres;

--
-- Name: grupos_acessos_empresas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE grupos_acessos_empresas_id_seq OWNED BY grupos_acessos_empresas.id;


--
-- Name: grupos_acessos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grupos_acessos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grupos_acessos_id_seq OWNER TO postgres;

--
-- Name: grupos_acessos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE grupos_acessos_id_seq OWNED BY grupos_acessos.id;


--
-- Name: grupos_acessos_perfis; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grupos_acessos_perfis (
    id integer NOT NULL,
    grupo_acesso_id integer,
    empresa_id integer,
    perfil_id integer
);


ALTER TABLE public.grupos_acessos_perfis OWNER TO postgres;

--
-- Name: grupos_acessos_perfis_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grupos_acessos_perfis_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grupos_acessos_perfis_id_seq OWNER TO postgres;

--
-- Name: grupos_acessos_perfis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE grupos_acessos_perfis_id_seq OWNED BY grupos_acessos_perfis.id;


--
-- Name: grupos_acessos_programas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grupos_acessos_programas (
    id integer NOT NULL,
    grupo_acesso_id integer,
    empresa_id integer,
    perfil_id integer,
    programa_id integer,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.grupos_acessos_programas OWNER TO postgres;

--
-- Name: grupos_acessos_programas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grupos_acessos_programas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grupos_acessos_programas_id_seq OWNER TO postgres;

--
-- Name: grupos_acessos_programas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE grupos_acessos_programas_id_seq OWNED BY grupos_acessos_programas.id;


--
-- Name: grupos_acessos_programas_permissoes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grupos_acessos_programas_permissoes (
    id integer NOT NULL,
    grupo_acesso_id integer,
    sys_metodo_id integer,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.grupos_acessos_programas_permissoes OWNER TO postgres;

--
-- Name: grupos_acessos_programas_permissoes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grupos_acessos_programas_permissoes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grupos_acessos_programas_permissoes_id_seq OWNER TO postgres;

--
-- Name: grupos_acessos_programas_permissoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE grupos_acessos_programas_permissoes_id_seq OWNED BY grupos_acessos_programas_permissoes.id;


--
-- Name: log_fields; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE log_fields (
    id integer NOT NULL,
    log_table_id integer,
    field_name character varying(255) DEFAULT NULL::character varying,
    old_value text,
    new_value text
);


ALTER TABLE public.log_fields OWNER TO postgres;

--
-- Name: log_fields_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE log_fields_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_fields_id_seq OWNER TO postgres;

--
-- Name: log_fields_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE log_fields_id_seq OWNED BY log_fields.id;


--
-- Name: log_fields_structures; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE log_fields_structures (
    id integer NOT NULL,
    log_table_structure_id integer,
    field_name character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.log_fields_structures OWNER TO postgres;

--
-- Name: log_fields_structures_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE log_fields_structures_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_fields_structures_id_seq OWNER TO postgres;

--
-- Name: log_fields_structures_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE log_fields_structures_id_seq OWNED BY log_fields_structures.id;


--
-- Name: log_tables; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE log_tables (
    id integer NOT NULL,
    table_name character varying(255) DEFAULT NULL::character varying,
    table_id integer,
    flg_action character varying(10) DEFAULT NULL::character varying,
    dt_register timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.log_tables OWNER TO postgres;

--
-- Name: log_tables_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE log_tables_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_tables_id_seq OWNER TO postgres;

--
-- Name: log_tables_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE log_tables_id_seq OWNED BY log_tables.id;


--
-- Name: log_tables_structures; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE log_tables_structures (
    id integer NOT NULL,
    table_name character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.log_tables_structures OWNER TO postgres;

--
-- Name: log_tables_structures_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE log_tables_structures_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.log_tables_structures_id_seq OWNER TO postgres;

--
-- Name: log_tables_structures_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE log_tables_structures_id_seq OWNED BY log_tables_structures.id;


--
-- Name: parametros; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE parametros (
    id integer NOT NULL,
    nome character varying(255) DEFAULT NULL::character varying,
    descricao character varying(255) DEFAULT NULL::character varying,
    valor character varying(255) DEFAULT NULL::character varying,
    dt_cadastro date
);


ALTER TABLE public.parametros OWNER TO postgres;

--
-- Name: parametros_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE parametros_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.parametros_id_seq OWNER TO postgres;

--
-- Name: parametros_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE parametros_id_seq OWNED BY parametros.id;


--
-- Name: perfis; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE perfis (
    id integer NOT NULL,
    nome_perfil character varying(255) NOT NULL,
    flg_ativo character varying(1) DEFAULT 'S'::character varying,
    dt_cadastro date
);


ALTER TABLE public.perfis OWNER TO postgres;

--
-- Name: perfis_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE perfis_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.perfis_id_seq OWNER TO postgres;

--
-- Name: perfis_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE perfis_id_seq OWNED BY perfis.id;


--
-- Name: perfis_programas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE perfis_programas (
    id integer NOT NULL,
    perfil_id integer,
    programa_id integer,
    programa_pai integer,
    ordem integer,
    flg_ativo character varying(1) DEFAULT NULL::character varying
);


ALTER TABLE public.perfis_programas OWNER TO postgres;

--
-- Name: perfis_programas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE perfis_programas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.perfis_programas_id_seq OWNER TO postgres;

--
-- Name: perfis_programas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE perfis_programas_id_seq OWNED BY perfis_programas.id;


--
-- Name: pessoas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pessoas (
    id integer NOT NULL,
    nome character varying(255) NOT NULL,
    cpf character varying(15) DEFAULT NULL::character varying,
    rg character varying(15) DEFAULT NULL::character varying,
    estado_civil_id integer,
    sexo character varying(1) DEFAULT NULL::character varying,
    dt_nascimento date,
    nome_pai character varying(255) DEFAULT NULL::character varying,
    nome_mae character varying(255) DEFAULT NULL::character varying,
    telefone character varying(25) DEFAULT NULL::character varying,
    celular character varying(25) DEFAULT NULL::character varying,
    email character varying(255) DEFAULT NULL::character varying,
    observacao text,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL,
    orgao_emissor_rg character varying(10) DEFAULT NULL::character varying,
    orgao_emissor_rg_unidade_federativa_id integer,
    flg_mao_escrita character varying(1) DEFAULT 'D'::character varying,
    nacionalidade character varying(255) DEFAULT NULL::character varying,
    dt_atualizacao_gol date,
    nr_titulo_eleitor character varying(15) DEFAULT NULL::character varying,
    hash_ativacao character varying(255) DEFAULT NULL::character varying,
    email_ativacao character varying(255) DEFAULT NULL::character varying,
    senha_ativacao text,
    foto_carteira_id integer,
    cod_carteira integer,
    pessoa_tipo_id integer,
    nome_consulta character varying(255),
    cidade_id integer,
    profissao character varying(50)
);


ALTER TABLE public.pessoas OWNER TO postgres;

--
-- Name: pessoas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pessoas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pessoas_id_seq OWNER TO postgres;

--
-- Name: pessoas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pessoas_id_seq OWNED BY pessoas.id;


--
-- Name: pessoas_tipos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE pessoas_tipos (
    id integer NOT NULL,
    tipo character varying(50) DEFAULT NULL::character varying,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.pessoas_tipos OWNER TO postgres;

--
-- Name: pessoas_tipos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pessoas_tipos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pessoas_tipos_id_seq OWNER TO postgres;

--
-- Name: pessoas_tipos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE pessoas_tipos_id_seq OWNED BY pessoas_tipos.id;


--
-- Name: programas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE programas (
    id integer NOT NULL,
    nome_programa character varying(255) DEFAULT NULL::character varying,
    descricao character varying(255) DEFAULT NULL::character varying,
    link character varying(255) DEFAULT NULL::character varying,
    onclick character varying(255) DEFAULT NULL::character varying,
    dt_cadastro date
);


ALTER TABLE public.programas OWNER TO postgres;

--
-- Name: programas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE programas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.programas_id_seq OWNER TO postgres;

--
-- Name: programas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE programas_id_seq OWNED BY programas.id;


--
-- Name: programas_parametros; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE programas_parametros (
    id integer NOT NULL,
    programa_id integer,
    nome character varying(255) DEFAULT NULL::character varying,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.programas_parametros OWNER TO postgres;

--
-- Name: programas_parametros_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE programas_parametros_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.programas_parametros_id_seq OWNER TO postgres;

--
-- Name: programas_parametros_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE programas_parametros_id_seq OWNED BY programas_parametros.id;


--
-- Name: sys_metodos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sys_metodos (
    id integer NOT NULL,
    classe character varying(255) DEFAULT NULL::character varying,
    metodo character varying(255) DEFAULT NULL::character varying,
    apelido character varying(255) DEFAULT NULL::character varying,
    privado integer,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.sys_metodos OWNER TO postgres;

--
-- Name: sys_metodos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sys_metodos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sys_metodos_id_seq OWNER TO postgres;

--
-- Name: sys_metodos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sys_metodos_id_seq OWNED BY sys_metodos.id;


--
-- Name: sys_permissoes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sys_permissoes (
    id integer NOT NULL,
    sys_metodo_id integer,
    usuario_id integer,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.sys_permissoes OWNER TO postgres;

--
-- Name: sys_permissoes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE sys_permissoes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.sys_permissoes_id_seq OWNER TO postgres;

--
-- Name: sys_permissoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE sys_permissoes_id_seq OWNED BY sys_permissoes.id;


--
-- Name: telefones; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE telefones (
    id integer NOT NULL,
    pessoa_id integer NOT NULL,
    telefone_tipo_id integer NOT NULL,
    numero character varying(14) DEFAULT NULL::character varying,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.telefones OWNER TO postgres;

--
-- Name: telefones_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE telefones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.telefones_id_seq OWNER TO postgres;

--
-- Name: telefones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE telefones_id_seq OWNED BY telefones.id;


--
-- Name: telefones_tipos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE telefones_tipos (
    id integer NOT NULL,
    descricao character varying(255) DEFAULT NULL::character varying,
    flg_tipo character varying(1) DEFAULT NULL::character varying,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.telefones_tipos OWNER TO postgres;

--
-- Name: telefones_tipos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE telefones_tipos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.telefones_tipos_id_seq OWNER TO postgres;

--
-- Name: telefones_tipos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE telefones_tipos_id_seq OWNED BY telefones_tipos.id;


--
-- Name: tipo_enderecos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_enderecos (
    id integer NOT NULL,
    nome character varying(255) DEFAULT NULL::character varying
);


ALTER TABLE public.tipo_enderecos OWNER TO postgres;

--
-- Name: tipo_enderecos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_enderecos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_enderecos_id_seq OWNER TO postgres;

--
-- Name: tipo_enderecos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tipo_enderecos_id_seq OWNED BY tipo_enderecos.id;


--
-- Name: unidades_federativas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE unidades_federativas (
    id integer NOT NULL,
    sigla character varying(2) DEFAULT NULL::character varying,
    nome character varying(255) DEFAULT NULL::character varying,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.unidades_federativas OWNER TO postgres;

--
-- Name: unidades_federativas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE unidades_federativas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.unidades_federativas_id_seq OWNER TO postgres;

--
-- Name: unidades_federativas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE unidades_federativas_id_seq OWNED BY unidades_federativas.id;


--
-- Name: uploads; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE uploads (
    id integer NOT NULL,
    nome_gerado character varying(255) DEFAULT NULL::character varying,
    nome_original character varying(255) DEFAULT NULL::character varying,
    tamanho character varying(10) DEFAULT NULL::character varying,
    tipo character varying(255) DEFAULT NULL::character varying,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.uploads OWNER TO postgres;

--
-- Name: uploads_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE uploads_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.uploads_id_seq OWNER TO postgres;

--
-- Name: uploads_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE uploads_id_seq OWNED BY uploads.id;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usuarios (
    id integer NOT NULL,
    pessoa_id integer NOT NULL,
    login character varying(255) NOT NULL,
    senha text,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL,
    hash_id character varying(255) DEFAULT NULL::character varying,
    avatar_id integer,
    tema character varying(45) DEFAULT 'redmond'::character varying
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- Name: usuarios_empresas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usuarios_empresas (
    usuario_id integer NOT NULL,
    empresa_id integer NOT NULL,
    empresa_boot character varying(1) DEFAULT NULL::character varying
);


ALTER TABLE public.usuarios_empresas OWNER TO postgres;

--
-- Name: usuarios_grupos_acessos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usuarios_grupos_acessos (
    id integer NOT NULL,
    usuario_id integer,
    grupo_acesso_id integer,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.usuarios_grupos_acessos OWNER TO postgres;

--
-- Name: usuarios_grupos_acessos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuarios_grupos_acessos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_grupos_acessos_id_seq OWNER TO postgres;

--
-- Name: usuarios_grupos_acessos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE usuarios_grupos_acessos_id_seq OWNED BY usuarios_grupos_acessos.id;


--
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuarios_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_id_seq OWNER TO postgres;

--
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE usuarios_id_seq OWNED BY usuarios.id;


--
-- Name: usuarios_perfis; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usuarios_perfis (
    empresa_id integer,
    usuario_id integer,
    perfil_id integer
);


ALTER TABLE public.usuarios_perfis OWNER TO postgres;

--
-- Name: usuarios_programas_acessos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usuarios_programas_acessos (
    id integer NOT NULL,
    usuario_id integer,
    empresa_id integer,
    perfil_id integer,
    programa_id integer,
    dt_cadastro timestamp without time zone DEFAULT now() NOT NULL
);


ALTER TABLE public.usuarios_programas_acessos OWNER TO postgres;

--
-- Name: usuarios_programas_acessos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuarios_programas_acessos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.usuarios_programas_acessos_id_seq OWNER TO postgres;

--
-- Name: usuarios_programas_acessos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE usuarios_programas_acessos_id_seq OWNED BY usuarios_programas_acessos.id;


SET search_path = paraformal, pg_catalog;

--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY atividades_registradas ALTER COLUMN id SET DEFAULT nextval('atividades_registradas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY cenas ALTER COLUMN id SET DEFAULT nextval('cenas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY climas ALTER COLUMN id SET DEFAULT nextval('climas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY climas_paraformalidade ALTER COLUMN id SET DEFAULT nextval('climas_paraformalidade_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY colaboradores_paraformalidades ALTER COLUMN id SET DEFAULT nextval('colaboradores_paraformalidades_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY condicionantes_ambientais ALTER COLUMN id SET DEFAULT nextval('condicionantes_ambientais_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY condicionantes_ambientais_paraformalidade ALTER COLUMN id SET DEFAULT nextval('condicionantes_ambientais_paraformalidade_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY condicoes_ambientais ALTER COLUMN id SET DEFAULT nextval('condicoes_ambientais_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY corpo_numeros ALTER COLUMN id SET DEFAULT nextval('corpo_numeros_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY corpo_posicoes ALTER COLUMN id SET DEFAULT nextval('corpo_posicoes_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipamento_instalacoes ALTER COLUMN id SET DEFAULT nextval('equipamento_instalacoes_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipamento_instalacoes_paraformalidade ALTER COLUMN id SET DEFAULT nextval('equipamento_instalacoes_paraformalidade_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipamento_mobilidades ALTER COLUMN id SET DEFAULT nextval('equipamento_mobilidades_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipamento_portes ALTER COLUMN id SET DEFAULT nextval('equipamento_portes_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipe_grupos_atividade ALTER COLUMN id SET DEFAULT nextval('equipe_grupos_atividade_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipe_registros_atividades ALTER COLUMN id SET DEFAULT nextval('equipe_registros_atividades_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY espaco_localizacoes ALTER COLUMN id SET DEFAULT nextval('espaco_localizacoes_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY grupos_atividades ALTER COLUMN id SET DEFAULT nextval('grupos_atividades_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY paraformalidades ALTER COLUMN id SET DEFAULT nextval('paraformalidades_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY participacoes_equipe ALTER COLUMN id SET DEFAULT nextval('participacoes_equipe_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY pessoa_procedencias ALTER COLUMN id SET DEFAULT nextval('pessoa_procedencias_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY quantidades_registrada ALTER COLUMN id SET DEFAULT nextval('quantidades_registrada_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY sentidos ALTER COLUMN id SET DEFAULT nextval('sentidos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY sentidos_paraformalidade ALTER COLUMN id SET DEFAULT nextval('sentidos_paraformalidade_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY turnos_ocorrencia ALTER COLUMN id SET DEFAULT nextval('turnos_ocorrencia_id_seq'::regclass);


SET search_path = public, pg_catalog;

--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cidades ALTER COLUMN id SET DEFAULT nextval('cidades_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY empresas ALTER COLUMN id SET DEFAULT nextval('empresas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY enderecos ALTER COLUMN id SET DEFAULT nextval('enderecos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY enderecos_tipos ALTER COLUMN id SET DEFAULT nextval('enderecos_tipos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estados_civis ALTER COLUMN id SET DEFAULT nextval('estados_civis_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos ALTER COLUMN id SET DEFAULT nextval('grupos_acessos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_empresas ALTER COLUMN id SET DEFAULT nextval('grupos_acessos_empresas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_perfis ALTER COLUMN id SET DEFAULT nextval('grupos_acessos_perfis_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_programas ALTER COLUMN id SET DEFAULT nextval('grupos_acessos_programas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_programas_permissoes ALTER COLUMN id SET DEFAULT nextval('grupos_acessos_programas_permissoes_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_fields ALTER COLUMN id SET DEFAULT nextval('log_fields_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_fields_structures ALTER COLUMN id SET DEFAULT nextval('log_fields_structures_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_tables ALTER COLUMN id SET DEFAULT nextval('log_tables_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_tables_structures ALTER COLUMN id SET DEFAULT nextval('log_tables_structures_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY parametros ALTER COLUMN id SET DEFAULT nextval('parametros_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY perfis ALTER COLUMN id SET DEFAULT nextval('perfis_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY perfis_programas ALTER COLUMN id SET DEFAULT nextval('perfis_programas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pessoas ALTER COLUMN id SET DEFAULT nextval('pessoas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pessoas_tipos ALTER COLUMN id SET DEFAULT nextval('pessoas_tipos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY programas ALTER COLUMN id SET DEFAULT nextval('programas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY programas_parametros ALTER COLUMN id SET DEFAULT nextval('programas_parametros_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sys_metodos ALTER COLUMN id SET DEFAULT nextval('sys_metodos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sys_permissoes ALTER COLUMN id SET DEFAULT nextval('sys_permissoes_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY telefones ALTER COLUMN id SET DEFAULT nextval('telefones_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY telefones_tipos ALTER COLUMN id SET DEFAULT nextval('telefones_tipos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY tipo_enderecos ALTER COLUMN id SET DEFAULT nextval('tipo_enderecos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY unidades_federativas ALTER COLUMN id SET DEFAULT nextval('unidades_federativas_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY uploads ALTER COLUMN id SET DEFAULT nextval('uploads_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios ALTER COLUMN id SET DEFAULT nextval('usuarios_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_grupos_acessos ALTER COLUMN id SET DEFAULT nextval('usuarios_grupos_acessos_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_programas_acessos ALTER COLUMN id SET DEFAULT nextval('usuarios_programas_acessos_id_seq'::regclass);


SET search_path = paraformal, pg_catalog;

--
-- Data for Name: atividades_registradas; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY atividades_registradas (id, descricao, dt_cadastro) FROM stdin;
3	Cultura/Arte	2013-03-31 13:13:55.921853
4	Moradia	2013-03-31 13:13:58.953886
2	Comércio	2013-03-31 13:13:44.682867
\.


--
-- Name: atividades_registradas_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('atividades_registradas_id_seq', 4, true);


--
-- Data for Name: cenas; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY cenas (id, descricao, grupo_atividade_id, dt_ocorrencia, estaativo, dt_cadastro) FROM stdin;
\.


--
-- Name: cenas_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('cenas_id_seq', 8, true);


--
-- Data for Name: climas; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY climas (id, descricao, dt_cadastro) FROM stdin;
1	Sol	2013-02-24 09:58:30.586089
2	Chuva	2013-02-24 09:58:34.383718
3	Nublado	2013-02-24 09:58:39.301544
4	Vento	2013-02-24 09:58:44.853156
5	Quente	2013-02-24 09:58:49.98123
6	Ameno	2013-02-24 09:58:53.732659
7	Frio	2013-02-24 09:58:58.753763
\.


--
-- Name: climas_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('climas_id_seq', 7, true);


--
-- Data for Name: climas_paraformalidade; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY climas_paraformalidade (id, clima_id, paraformalidade_id, dt_cadastro) FROM stdin;
\.


--
-- Name: climas_paraformalidade_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('climas_paraformalidade_id_seq', 9, true);


--
-- Data for Name: colaboradores_paraformalidades; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY colaboradores_paraformalidades (id, pessoa_id, paraformalidade_id, dt_cadastro) FROM stdin;
\.


--
-- Name: colaboradores_paraformalidades_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('colaboradores_paraformalidades_id_seq', 11, true);


--
-- Data for Name: condicionantes_ambientais; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY condicionantes_ambientais (id, descricao, dt_cadastro) FROM stdin;
2	Sombra	2013-03-31 13:23:15.338414
3	Movimento	2013-03-31 13:23:18.353901
4	Natureza	2013-03-31 13:23:22.553876
5	Piso	2013-03-31 13:23:24.953889
6	Parede para Apoio	2013-03-31 13:23:31.066271
\.


--
-- Name: condicionantes_ambientais_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('condicionantes_ambientais_id_seq', 6, true);


--
-- Data for Name: condicionantes_ambientais_paraformalidade; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY condicionantes_ambientais_paraformalidade (id, condicionante_ambiental_id, paraformalidade_id, dt_cadastro) FROM stdin;
\.


--
-- Name: condicionantes_ambientais_paraformalidade_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('condicionantes_ambientais_paraformalidade_id_seq', 10, true);


--
-- Data for Name: condicoes_ambientais; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY condicoes_ambientais (id, descricao, dt_cadastro) FROM stdin;
\.


--
-- Name: condicoes_ambientais_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('condicoes_ambientais_id_seq', 6, true);


--
-- Data for Name: corpo_numeros; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY corpo_numeros (id, descricao, dt_cadastro) FROM stdin;
2	Único	2013-03-31 13:17:50.466024
3	Grupo	2013-03-31 13:17:53.361997
\.


--
-- Name: corpo_numeros_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('corpo_numeros_id_seq', 3, true);


--
-- Data for Name: corpo_posicoes; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY corpo_posicoes (id, descricao, dt_cadastro) FROM stdin;
2	Sentado	2013-03-31 13:16:51.609788
3	Em pé	2013-03-31 13:16:54.297856
\.


--
-- Name: corpo_posicoes_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('corpo_posicoes_id_seq', 3, true);


--
-- Data for Name: equipamento_instalacoes; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY equipamento_instalacoes (id, descricao, dt_cadastro) FROM stdin;
1	Elétrica	2013-02-24 10:21:11.230024
2	Hidráulica	2013-02-24 10:21:22.440499
3	Sanitárias	2013-02-24 10:21:38.929426
4	Telefônica	2013-02-24 10:21:51.217367
5	Teve a Cabo	2013-02-24 10:22:02.122299
6	Nenhuma	2013-02-24 10:22:08.571127
\.


--
-- Name: equipamento_instalacoes_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('equipamento_instalacoes_id_seq', 6, true);


--
-- Data for Name: equipamento_instalacoes_paraformalidade; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY equipamento_instalacoes_paraformalidade (id, equipamento_instalacao_id, paraformalidade_id, dt_cadastro) FROM stdin;
\.


--
-- Name: equipamento_instalacoes_paraformalidade_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('equipamento_instalacoes_paraformalidade_id_seq', 8, true);


--
-- Data for Name: equipamento_mobilidades; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY equipamento_mobilidades (id, descricao, dt_cadastro) FROM stdin;
2	Ambulante	2013-03-31 13:21:37.68989
3	Fixo	2013-03-31 13:21:40.353974
\.


--
-- Name: equipamento_mobilidades_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('equipamento_mobilidades_id_seq', 3, true);


--
-- Data for Name: equipamento_portes; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY equipamento_portes (id, descricao, dt_cadastro) FROM stdin;
2	Pequeno	2013-03-31 13:18:56.826483
3	Médio	2013-03-31 13:18:59.473645
4	Grande	2013-03-31 13:19:01.921855
\.


--
-- Name: equipamento_portes_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('equipamento_portes_id_seq', 4, true);


--
-- Data for Name: equipe_grupos_atividade; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY equipe_grupos_atividade (id, pessoa_id, grupo_atividade_id, participacao_equipe_id, dt_cadastro) FROM stdin;
\.


--
-- Name: equipe_grupos_atividade_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('equipe_grupos_atividade_id_seq', 5, true);


--
-- Data for Name: equipe_registros_atividades; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY equipe_registros_atividades (id, pessoa_id, entrada_saida, data_hora, atividade, remote_addr, x_forwoard, dt_cadastro) FROM stdin;
1	1	E	2013-02-24 14:37:04.277954	aaa	127.0.0.1/32	\N	2013-02-24 14:37:04.277954
\.


--
-- Name: equipe_registros_atividades_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('equipe_registros_atividades_id_seq', 1, true);


--
-- Data for Name: espaco_localizacoes; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY espaco_localizacoes (id, descricao, dt_cadastro) FROM stdin;
2	Vazio	2013-03-31 13:15:57.78604
3	Esquina	2013-03-31 13:16:00.978402
4	Praça	2013-03-31 13:16:04.530573
\.


--
-- Name: espaco_localizacoes_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('espaco_localizacoes_id_seq', 4, true);


--
-- Data for Name: grupos_atividades; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY grupos_atividades (id, cidade_id, descricao, geocode_origem_latitude, geocode_origem_longitude, geocode_destino_latitude, geocode_destino_longitude, dt_ocorrencia, dt_cadastro) FROM stdin;
\.


--
-- Name: grupos_atividades_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('grupos_atividades_id_seq', 1, true);


--
-- Data for Name: paraformalidades; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY paraformalidades (id, cena_id, upload_id, descricao, geo_latitude, geo_longitude, link, turno_ocorrencia_id, atividade_registrada_id, quantidade_registrada_id, espaco_localizacao_id, corpo_numero_id, corpo_posicao_id, equipamento_porte_id, equipamento_mobilidade_id, dt_ocorrencia, estaativa, dt_cadastro) FROM stdin;
\.


--
-- Name: paraformalidades_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('paraformalidades_id_seq', 31, true);


--
-- Data for Name: participacoes_equipe; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY participacoes_equipe (id, descricao, dt_cadastro) FROM stdin;
1	Coordenador	2013-03-26 12:29:54.028151
2	Membro da Equipe	2013-03-26 12:30:16.452266
3	Voluntário	2013-03-26 12:30:21.332047
4	Colaborador	2013-03-26 12:30:56.444224
\.


--
-- Name: participacoes_equipe_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('participacoes_equipe_id_seq', 33, true);


--
-- Data for Name: pessoa_procedencias; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY pessoa_procedencias (id, descricao, dt_cadastro) FROM stdin;
1	Nativo	2013-02-24 09:57:22.530299
2	Turista	2013-02-24 09:57:27.846297
\.


--
-- Name: pessoa_procedencias_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('pessoa_procedencias_id_seq', 2, true);


--
-- Data for Name: quantidades_registrada; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY quantidades_registrada (id, descricao, dt_cadastro) FROM stdin;
1	Não Selecionado	2013-03-31 13:14:57.737931
2	Unico	2013-03-31 13:15:08.361908
3	Grupo	2013-03-31 13:15:11.937896
\.


--
-- Name: quantidades_registrada_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('quantidades_registrada_id_seq', 3, true);


--
-- Data for Name: sentidos; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY sentidos (id, descricao, dt_cadastro) FROM stdin;
1	Tato	2013-02-24 09:40:17.395176
2	Cheiro	2013-02-24 09:40:22.200937
3	Sons	2013-02-24 09:40:26.42749
4	Cor/Textura	2013-02-24 09:40:33.903044
\.


--
-- Name: sentidos_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('sentidos_id_seq', 4, true);


--
-- Data for Name: sentidos_paraformalidade; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY sentidos_paraformalidade (id, sentido_id, paraformalidade_id, dt_cadastro) FROM stdin;
\.


--
-- Name: sentidos_paraformalidade_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('sentidos_paraformalidade_id_seq', 11, true);


--
-- Data for Name: turnos_ocorrencia; Type: TABLE DATA; Schema: paraformal; Owner: postgres
--

COPY turnos_ocorrencia (id, descricao, dt_cadastro) FROM stdin;
2	Manhã	2013-03-31 13:12:35.418106
3	Tarde	2013-03-31 13:12:37.833885
4	Noite	2013-03-31 13:12:41.179047
5	Madrugada	2013-03-31 13:12:45.907523
\.


--
-- Name: turnos_ocorrencia_id_seq; Type: SEQUENCE SET; Schema: paraformal; Owner: postgres
--

SELECT pg_catalog.setval('turnos_ocorrencia_id_seq', 5, true);


SET search_path = public, pg_catalog;

--
-- Data for Name: ci_sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY ci_sessions (session_id, ip_address, user_agent, last_activity, user_data) FROM stdin;
4c206176082e6dcca5e0f981fed19c1a	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/536.5 (K	1340489226	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3054:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/usuario">Usuários</a></li><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/perfil">Módulos</a></li><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/empresa">Setores</a></li><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastros/grupoAtividade">Grupos de Atividade</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/atividadeRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/colaborador">Colaboradores</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/condicaoAmbiental">Condições Ambientais</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/elementoSituacao">Elementos Situação</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/local">Locais</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/participacao">Participações</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/ponte">Pontes</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
3d104a23b4db74039884bcfbd71299e5	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.19 (	1337214452	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:1998:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/usuario">Usuários</a></li><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/perfil">Módulos</a></li><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/empresa">Setores</a></li><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://127.1.1.1/PlataformaDoParaformal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/atividadeRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/colaborador">Colaboradores</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/condicaoAmbiental">Condições Ambientais</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/elementoSituacao">Elementos Situação</a></span><li class="closed"><span><a href="http://127.1.1.1/PlataformaDoParaformal/paraformalidade/cadastrosBasicos/local">Locais</a></span></ul></li></ul></li>";}
eb9d523339dd122589c8646e1cb151f6	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.17 (	1361123511	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3566:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicoesAmbiental">Condições Ambientais</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
8b4587ee85311643277bc8f1cd7db1d5	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.17 (	1361727781	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3573:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
5ee3ebfff36fed6efe03690b8be2cf67	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.17 (	1361731698	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3573:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
b6ac8a05cfa687c4aca13fa2d6880334	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364999827	\N
345fe408064250b362b1c5a2adac18fd	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364909891	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3961:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/cidade/">Cidades</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
9cbeeb1282045c7f582d70a67b8cf040	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1365103588	\N
ec0251a092217e5cd88a046d7f18e3f6	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364909891	\N
c0b80a6b4402e0dc583829d6b909db00	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1365005263	\N
c414c992cd1e2f14502a8360618387ee	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1365084793	\N
bea411796eece320eab83dad62116dca	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.22 (	1364334922	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3873:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
2e7accf746f1eb0defb1e220db6a1eea	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1365168061	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3961:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/cidade/">Cidades</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
1c84e5861a783383c375f396bd0d30b7	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.22 (	1364341914	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3873:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
18242c7f787037d18b5a7f8fa25ff1ee	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364493014	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3873:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
186d9196a602825fb24ce0e58ded04fd	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364494145	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3873:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
72e9e23adad151e45cffbe53758293f4	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364909891	\N
217dd0b7c2087b0bfb86006d371627c0	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364848838	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3961:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/cidade/">Cidades</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
b7f11fd1fb29e53efe7fa52edd181724	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364748441	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3873:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
49601bec87e7ce4f89e4889943ff5099	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1365005263	\N
0eb7f233b2cd3506dfeecf53fe4a310f	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364821957	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3873:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
25b57c18ab59a7611b8f5b93085e082a	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364823606	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3873:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
e913bacf8f97073d2af425dd91db9bfd	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364842868	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3873:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
09ada56b22a353f49e94fbc812b8b4ec	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364845786	\N
33227500b6a5468cdb6a82740fc25952	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364845786	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3873:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
9419d7bb59ecd1498aab146f93ef5183	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364845786	\N
d8d383101ea0f5b8f8e9fb4b799add5f	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364998939	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3961:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/cidade/">Cidades</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
6173bf1c7cf50bbcd4f95b7acfe962c9	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364909891	\N
e09c918db557c4f97a6c972737ab562e	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364909891	\N
5c8df6fd52faf7b7c0cd3895e358d675	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1365029345	\N
437aea31b726963d91326b5f552299d6	127.0.0.1	Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.31 (	1364949996	a:2:{s:7:"usuario";s:242:"{"id":"1","pessoa_id":"1","login":"admin","senha":"d033e22ae348aeb5660fc2140aec35850c4da997","nome_pessoa":"Administrador do Sistema","email":"administrador@localhost","avatar_id":null,"nome_gerado":null,"nome_original":null,"tema":"redmond"}";s:4:"menu";s:3961:"<li><span>Área Administrativa</span><ul style="background: none !important;"><li class="closed"><span>Administrador do Sistema</span><ul style="background: none !important;"><li class="closed"><span>Usuários e módulos</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/usuario">Usuários</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/perfil">Módulos</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/grupoAcesso">Grupos de Acesso</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/pessoaTipo">Tipo Pessoas</a></li></ul></li><li class="closed"><span>Gerenciador</span><ul style="background: none !important;"><li><a href="http://localhost/PlataformaParaFormal/gerenciador/empresa">Setores</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/parametro">Parâmetros</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/programa">Programas</a></li><li><a href="http://localhost/PlataformaParaFormal/gerenciador/cidade/">Cidades</a></li></ul></li></ul></li></ul></li><li><span>Plataforma do Paraformal</span><ul style="background: none !important;"><li class="closed"><span>Cadastros</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/paraformalidade">Paraformalidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/gruposAtividades">Grupos de Atividade</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/colaboradores">Colaboradores</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastros/equipesGruposAtividades">Grupos de Atividades (Equipe)</a></span></ul></li><li class="closed"><span>Cadastros Básicos</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/atividadesRegistrada">Atividades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/condicionantesAmbiental">Condicionantes Ambiental</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoNumeros">Corpo Numeros</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/corpoPosicoes">Corpo Posições</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoInstalacoes">Equipamento Instalações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoMobilidades">Equipamento Mobilidades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/equipamentoPortes">Equipamento Portes</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/espacoLocalizacoes">Espaço Localizações</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/quantidadesRegistrada">Quantidades Registradas</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/cadastrosBasicos/turnosOcorrencia">Turnos Ocorrência</a></span></ul></li><li class="closed"><span>Equipe</span><ul style="background: none !important;"><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/registroAtividade">Registros de Atividades</a></span><li class="closed"><span><a href="http://localhost/PlataformaParaFormal/paraformalidade/equipe/verRegistroAtividade">Ver Registros de Atividades</a></span></ul></li></ul></li>";}
\.


--
-- Data for Name: cidades; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY cidades (id, unidade_federativa_id, nome, dt_cadastro, geo_latitude, geo_longitude) FROM stdin;
1	1	ACRELÂNDIA	2010-03-11 00:00:00	\N	\N
2	1	ASSIS BRASIL	2010-03-11 00:00:00	\N	\N
3	1	BRASILÉIA	2010-03-11 00:00:00	\N	\N
4	1	BUJARI	2010-03-11 00:00:00	\N	\N
5	1	CAPIXABA	2010-03-11 00:00:00	\N	\N
6	1	CRUZEIRO DO SUL	2010-03-11 00:00:00	\N	\N
7	1	EPITACIOLÂNDIA	2010-03-11 00:00:00	\N	\N
8	1	FEIJÓ	2010-03-11 00:00:00	\N	\N
9	1	JORDÃO	2010-03-11 00:00:00	\N	\N
10	1	MANCIO LIMA	2010-03-11 00:00:00	\N	\N
11	1	MANOEL URBANO	2010-03-11 00:00:00	\N	\N
12	1	MARECHAL THAUMATURGO	2010-03-11 00:00:00	\N	\N
13	1	PLÁCIDO DE CASTRO	2010-03-11 00:00:00	\N	\N
14	1	PORTO ACRE	2010-03-11 00:00:00	\N	\N
15	1	PORTO WALTER	2010-03-11 00:00:00	\N	\N
16	1	RIO BRANCO	2010-03-11 00:00:00	\N	\N
17	1	RODRIGUES ALVES	2010-03-11 00:00:00	\N	\N
18	1	SANTA ROSA DO PURUS	2010-03-11 00:00:00	\N	\N
19	1	SENA MADUREIRA	2010-03-11 00:00:00	\N	\N
20	1	SENADOR GUIOMARD	2010-03-11 00:00:00	\N	\N
21	1	TARAUACÁ	2010-03-11 00:00:00	\N	\N
22	1	XAPURI	2010-03-11 00:00:00	\N	\N
23	2	ÁGUA BRANCA	2010-03-11 00:00:00	\N	\N
24	2	ANADIA	2010-03-11 00:00:00	\N	\N
25	2	ARAPIRACA	2010-03-11 00:00:00	\N	\N
26	2	ATALAIA	2010-03-11 00:00:00	\N	\N
27	2	BARRA DE SANTO ANTÔNIO	2010-03-11 00:00:00	\N	\N
28	2	BARRA DE SÃO MIGUEL	2010-03-11 00:00:00	\N	\N
29	2	BATALHA	2010-03-11 00:00:00	\N	\N
30	2	BELÉM	2010-03-11 00:00:00	\N	\N
31	2	BELO MONTE	2010-03-11 00:00:00	\N	\N
32	2	BOCA DA MATA	2010-03-11 00:00:00	\N	\N
33	2	BRANQUINHA	2010-03-11 00:00:00	\N	\N
34	2	CACIMBINHAS	2010-03-11 00:00:00	\N	\N
35	2	CAJUEIRO	2010-03-11 00:00:00	\N	\N
36	2	CAMPESTRE	2010-03-11 00:00:00	\N	\N
37	2	CAMPO ALEGRE	2010-03-11 00:00:00	\N	\N
38	2	CAMPO GRANDE	2010-03-11 00:00:00	\N	\N
39	2	CANAPI	2010-03-11 00:00:00	\N	\N
40	2	CAPELA	2010-03-11 00:00:00	\N	\N
41	2	CARNEIROS	2010-03-11 00:00:00	\N	\N
42	2	CHÃ PRETA	2010-03-11 00:00:00	\N	\N
43	2	COITÉ DO NÓIA	2010-03-11 00:00:00	\N	\N
44	2	COLÔNIA LEOPOLDINA	2010-03-11 00:00:00	\N	\N
45	2	COQUEIRO SECO	2010-03-11 00:00:00	\N	\N
46	2	CORURIPE	2010-03-11 00:00:00	\N	\N
47	2	CRAIBAS	2010-03-11 00:00:00	\N	\N
48	2	DELMIRO GOUVEIA	2010-03-11 00:00:00	\N	\N
49	2	DOIS RIACHOS	2010-03-11 00:00:00	\N	\N
50	2	ESTRELA DE ALAGOAS	2010-03-11 00:00:00	\N	\N
51	2	FEIRA GRANDE	2010-03-11 00:00:00	\N	\N
52	2	FELIZ DESERTO	2010-03-11 00:00:00	\N	\N
53	2	FLEXEIRAS	2010-03-11 00:00:00	\N	\N
54	2	GIRAU DO PONCIANO	2010-03-11 00:00:00	\N	\N
55	2	IBATEGUARA	2010-03-11 00:00:00	\N	\N
56	2	IGACI	2010-03-11 00:00:00	\N	\N
57	2	IGREJA NOVA	2010-03-11 00:00:00	\N	\N
58	2	INHAPI	2010-03-11 00:00:00	\N	\N
59	2	JACARÉ DOS HOMENS	2010-03-11 00:00:00	\N	\N
60	2	JACUÍPE	2010-03-11 00:00:00	\N	\N
61	2	JAPARATINGA	2010-03-11 00:00:00	\N	\N
62	2	JARAMATAIA	2010-03-11 00:00:00	\N	\N
63	2	JEQUIÁ DA PRAIA	2010-03-11 00:00:00	\N	\N
64	2	JOAQUIM GOMES	2010-03-11 00:00:00	\N	\N
65	2	JUNDIÁ	2010-03-11 00:00:00	\N	\N
66	2	JUNQUEIRO	2010-03-11 00:00:00	\N	\N
67	2	LAGOA DA CANOA	2010-03-11 00:00:00	\N	\N
68	2	LIMOEIRO DE ANADIA	2010-03-11 00:00:00	\N	\N
69	2	MACEIÓ	2010-03-11 00:00:00	\N	\N
70	2	MAJOR ISIDORO	2010-03-11 00:00:00	\N	\N
71	2	MAR VERMELHO	2010-03-11 00:00:00	\N	\N
72	2	MARAGOGI	2010-03-11 00:00:00	\N	\N
73	2	MARAVILHA	2010-03-11 00:00:00	\N	\N
74	2	MARECHAL DEODORO	2010-03-11 00:00:00	\N	\N
75	2	MARIBONDO	2010-03-11 00:00:00	\N	\N
76	2	MATA GRANDE	2010-03-11 00:00:00	\N	\N
77	2	MATRIZ DE CAMARAGIBE	2010-03-11 00:00:00	\N	\N
78	2	MESSIAS	2010-03-11 00:00:00	\N	\N
79	2	MINADOR DO NEGRÃO	2010-03-11 00:00:00	\N	\N
80	2	MONTEIRÓPOLIS	2010-03-11 00:00:00	\N	\N
81	2	MURICI	2010-03-11 00:00:00	\N	\N
82	2	NOVO LINO	2010-03-11 00:00:00	\N	\N
83	2	OLHO D  ÁGUA DO CASADO	2010-03-11 00:00:00	\N	\N
84	2	OLHO D ÁGUA DAS FLORES	2010-03-11 00:00:00	\N	\N
85	2	OLHO D ÁGUA GRANDE	2010-03-11 00:00:00	\N	\N
86	2	OLIVENÇA	2010-03-11 00:00:00	\N	\N
87	2	OURO BRANCO	2010-03-11 00:00:00	\N	\N
88	2	PALESTINA	2010-03-11 00:00:00	\N	\N
89	2	PALMEIRA DOS ÍNDIOS	2010-03-11 00:00:00	\N	\N
90	2	PÃO DE AÇÚCAR	2010-03-11 00:00:00	\N	\N
91	2	PARICONHA	2010-03-11 00:00:00	\N	\N
92	2	PARIPUEIRA	2010-03-11 00:00:00	\N	\N
93	2	PASSO DE CAMARAGIBE	2010-03-11 00:00:00	\N	\N
94	2	PAULO JACINTO	2010-03-11 00:00:00	\N	\N
95	2	PENEDO	2010-03-11 00:00:00	\N	\N
96	2	PIAÇABUCU	2010-03-11 00:00:00	\N	\N
97	2	PILAR	2010-03-11 00:00:00	\N	\N
98	2	PINDOBA	2010-03-11 00:00:00	\N	\N
99	2	PIRANHAS	2010-03-11 00:00:00	\N	\N
100	2	POÇO DAS TRINCHEIRAS	2010-03-11 00:00:00	\N	\N
101	2	PORTO CALVO	2010-03-11 00:00:00	\N	\N
102	2	PORTO DE PEDRAS	2010-03-11 00:00:00	\N	\N
103	2	PORTO REAL DO COLÉGIO	2010-03-11 00:00:00	\N	\N
104	2	QUEBRÂNGULO	2010-03-11 00:00:00	\N	\N
105	2	RIO LARGO	2010-03-11 00:00:00	\N	\N
106	2	ROTEIRO	2010-03-11 00:00:00	\N	\N
107	2	SANTA LUZIA DO NORTE	2010-03-11 00:00:00	\N	\N
108	2	SANTANA DE IPANEMA	2010-03-11 00:00:00	\N	\N
109	2	SANTANA DO MUNDAU	2010-03-11 00:00:00	\N	\N
110	2	SÃO BRÁS	2010-03-11 00:00:00	\N	\N
111	2	SÃO JOSÉ DA LAJE	2010-03-11 00:00:00	\N	\N
112	2	SÃO JOSÉ DA TAPERA	2010-03-11 00:00:00	\N	\N
113	2	SÃO LUÍS DO QUITUNDE	2010-03-11 00:00:00	\N	\N
114	2	SÃO MIGUEL DOS CAMPOS	2010-03-11 00:00:00	\N	\N
115	2	SÃO MIGUEL DOS MILAGRES	2010-03-11 00:00:00	\N	\N
116	2	SÃO SEBASTIÃO	2010-03-11 00:00:00	\N	\N
117	2	SATUBA	2010-03-11 00:00:00	\N	\N
118	2	SENADOR RUI PALMEIRA	2010-03-11 00:00:00	\N	\N
119	2	TANQUE D ARCA	2010-03-11 00:00:00	\N	\N
120	2	TAQUARANA	2010-03-11 00:00:00	\N	\N
121	2	TEOTÔNIO VILELA	2010-03-11 00:00:00	\N	\N
122	2	TRAIPU	2010-03-11 00:00:00	\N	\N
123	2	UNIÃO DOS PALMARES	2010-03-11 00:00:00	\N	\N
124	2	VIÇOSA	2010-03-11 00:00:00	\N	\N
125	3	ALVARÃES	2010-03-11 00:00:00	\N	\N
126	3	AMATURA	2010-03-11 00:00:00	\N	\N
127	3	ANAMÃ	2010-03-11 00:00:00	\N	\N
128	3	ANORI	2010-03-11 00:00:00	\N	\N
129	3	APUI	2010-03-11 00:00:00	\N	\N
130	3	ATALAIA DO NORTE	2010-03-11 00:00:00	\N	\N
131	3	AUTAZES	2010-03-11 00:00:00	\N	\N
132	3	BARCELOS	2010-03-11 00:00:00	\N	\N
133	3	BARREIRINHA	2010-03-11 00:00:00	\N	\N
134	3	BENJAMIN CONSTANT	2010-03-11 00:00:00	\N	\N
135	3	BERURI	2010-03-11 00:00:00	\N	\N
136	3	BOA VISTA DO RAMOS	2010-03-11 00:00:00	\N	\N
137	3	BOCA DO ACRE	2010-03-11 00:00:00	\N	\N
138	3	BORBA	2010-03-11 00:00:00	\N	\N
139	3	CAAPIRANGA	2010-03-11 00:00:00	\N	\N
140	3	CANUTAMA	2010-03-11 00:00:00	\N	\N
141	3	CARAUARI	2010-03-11 00:00:00	\N	\N
142	3	CAREIRO	2010-03-11 00:00:00	\N	\N
143	3	CAREIRO DA VÁRZEA	2010-03-11 00:00:00	\N	\N
144	3	COARI	2010-03-11 00:00:00	\N	\N
145	3	CODAJÁS	2010-03-11 00:00:00	\N	\N
146	3	EIRUNEPE	2010-03-11 00:00:00	\N	\N
147	3	ENVIRA	2010-03-11 00:00:00	\N	\N
148	3	FONTE BOA	2010-03-11 00:00:00	\N	\N
149	3	GUAJARÁ	2010-03-11 00:00:00	\N	\N
150	3	HUMAITÁ	2010-03-11 00:00:00	\N	\N
151	3	IPIXUNA	2010-03-11 00:00:00	\N	\N
152	3	IRANDUBA	2010-03-11 00:00:00	\N	\N
153	3	ITACOATIARA	2010-03-11 00:00:00	\N	\N
154	3	ITAMARATI	2010-03-11 00:00:00	\N	\N
155	3	ITAPIRANGA	2010-03-11 00:00:00	\N	\N
156	3	JAPURÁ	2010-03-11 00:00:00	\N	\N
157	3	JURUÁ	2010-03-11 00:00:00	\N	\N
158	3	JUTAI	2010-03-11 00:00:00	\N	\N
159	3	LABREA	2010-03-11 00:00:00	\N	\N
160	3	MANACAPURU	2010-03-11 00:00:00	\N	\N
161	3	MANAQUIRI	2010-03-11 00:00:00	\N	\N
162	3	MANAUS	2010-03-11 00:00:00	\N	\N
163	3	MANICORÉ	2010-03-11 00:00:00	\N	\N
164	3	MARAÃ	2010-03-11 00:00:00	\N	\N
165	3	MAUÉS	2010-03-11 00:00:00	\N	\N
166	3	NHAMUNDA	2010-03-11 00:00:00	\N	\N
167	3	NOVA OLINDA DO NORTE	2010-03-11 00:00:00	\N	\N
168	3	NOVO AIRÃO	2010-03-11 00:00:00	\N	\N
169	3	NOVO ARIPUANÃ	2010-03-11 00:00:00	\N	\N
170	3	PARINTINS	2010-03-11 00:00:00	\N	\N
171	3	PAUINI	2010-03-11 00:00:00	\N	\N
172	3	PRESIDENTE FIGUEIREDO	2010-03-11 00:00:00	\N	\N
173	3	RIO PRETO DA EVA	2010-03-11 00:00:00	\N	\N
174	3	SANTA ISABEL DO RIO NEGRO	2010-03-11 00:00:00	\N	\N
175	3	SANTO ANTONIO  DO IÇÁ	2010-03-11 00:00:00	\N	\N
176	3	SÃO GABRIEL DA CACHOEIRA	2010-03-11 00:00:00	\N	\N
177	3	SÃO PAULO DE OLIVENÇA	2010-03-11 00:00:00	\N	\N
178	3	SÃO SEBASTIÃO DO UATUMÃ	2010-03-11 00:00:00	\N	\N
179	3	SILVES	2010-03-11 00:00:00	\N	\N
180	3	TABATINGA	2010-03-11 00:00:00	\N	\N
181	3	TAPAUA	2010-03-11 00:00:00	\N	\N
182	3	TEFÉ	2010-03-11 00:00:00	\N	\N
183	3	TONANTINS	2010-03-11 00:00:00	\N	\N
184	3	UARINI	2010-03-11 00:00:00	\N	\N
185	3	URUCARA	2010-03-11 00:00:00	\N	\N
186	3	URUCURITUBA	2010-03-11 00:00:00	\N	\N
187	4	AMAPÁ	2010-03-11 00:00:00	\N	\N
188	4	CALÇOENE	2010-03-11 00:00:00	\N	\N
189	4	CUTIAS	2010-03-11 00:00:00	\N	\N
190	4	FERREIRA GOMES	2010-03-11 00:00:00	\N	\N
191	4	ITAUBAL	2010-03-11 00:00:00	\N	\N
192	4	LARANJAL DO JARI	2010-03-11 00:00:00	\N	\N
193	4	MACAPÁ	2010-03-11 00:00:00	\N	\N
194	4	MAZAGÃO	2010-03-11 00:00:00	\N	\N
195	4	OIAPOQUE	2010-03-11 00:00:00	\N	\N
196	4	PEDRA BRANCA DO AMAPARI	2010-03-11 00:00:00	\N	\N
197	4	PORTO GRANDE	2010-03-11 00:00:00	\N	\N
198	4	PRACUUBA	2010-03-11 00:00:00	\N	\N
199	4	SANTANA	2010-03-11 00:00:00	\N	\N
200	4	SERRA DO NAVIO	2010-03-11 00:00:00	\N	\N
201	4	TARTARUGALZINHO	2010-03-11 00:00:00	\N	\N
202	4	VITÓRIA DO JARI	2010-03-11 00:00:00	\N	\N
203	5	ABAIRA	2010-03-11 00:00:00	\N	\N
204	5	ABARÉ	2010-03-11 00:00:00	\N	\N
205	5	ACAJUTIBA	2010-03-11 00:00:00	\N	\N
206	5	ADUSTINA	2010-03-11 00:00:00	\N	\N
207	5	ÁGUA FRIA	2010-03-11 00:00:00	\N	\N
208	5	AIQUARA	2010-03-11 00:00:00	\N	\N
209	5	ALAGOINHAS	2010-03-11 00:00:00	\N	\N
210	5	ALCOBAÇA	2010-03-11 00:00:00	\N	\N
211	5	ALMADINA	2010-03-11 00:00:00	\N	\N
212	5	AMARGOSA	2010-03-11 00:00:00	\N	\N
213	5	AMÉLIA RODRIGUES	2010-03-11 00:00:00	\N	\N
214	5	AMÉRICA DOURADA	2010-03-11 00:00:00	\N	\N
215	5	ANAGE	2010-03-11 00:00:00	\N	\N
216	5	ANDARAÍ	2010-03-11 00:00:00	\N	\N
217	5	ANDORINHA	2010-03-11 00:00:00	\N	\N
218	5	ANGICAL	2010-03-11 00:00:00	\N	\N
219	5	ANGUERA	2010-03-11 00:00:00	\N	\N
220	5	ANTAS	2010-03-11 00:00:00	\N	\N
221	5	ANTÔNIO CARDOSO	2010-03-11 00:00:00	\N	\N
222	5	ANTÔNIO GONÇALVES	2010-03-11 00:00:00	\N	\N
223	5	APORA	2010-03-11 00:00:00	\N	\N
224	5	APUAREMA	2010-03-11 00:00:00	\N	\N
225	5	ARAÇAS	2010-03-11 00:00:00	\N	\N
226	5	ARACATU	2010-03-11 00:00:00	\N	\N
227	5	ARACI	2010-03-11 00:00:00	\N	\N
228	5	ARAMARI	2010-03-11 00:00:00	\N	\N
229	5	ARATACA	2010-03-11 00:00:00	\N	\N
230	5	ARATUIPE	2010-03-11 00:00:00	\N	\N
231	5	AURELINO LEAL	2010-03-11 00:00:00	\N	\N
232	5	BAIANÓPOLIS	2010-03-11 00:00:00	\N	\N
233	5	BAIXA GRANDE	2010-03-11 00:00:00	\N	\N
234	5	BANZAE	2010-03-11 00:00:00	\N	\N
235	5	BARRA	2010-03-11 00:00:00	\N	\N
236	5	BARRA DA ESTIVA	2010-03-11 00:00:00	\N	\N
237	5	BARRA DO CHOÇA	2010-03-11 00:00:00	\N	\N
238	5	BARRA DO MENDES	2010-03-11 00:00:00	\N	\N
239	5	BARRA DO ROCHA	2010-03-11 00:00:00	\N	\N
240	5	BARREIRAS	2010-03-11 00:00:00	\N	\N
241	5	BARRO ALTO	2010-03-11 00:00:00	\N	\N
242	5	BARRO PRETO	2010-03-11 00:00:00	\N	\N
243	5	BARROCAS	2010-03-11 00:00:00	\N	\N
244	5	BELMONTE	2010-03-11 00:00:00	\N	\N
245	5	BELO CAMPO	2010-03-11 00:00:00	\N	\N
246	5	BIRITINGA	2010-03-11 00:00:00	\N	\N
247	5	BOA NOVA	2010-03-11 00:00:00	\N	\N
248	5	BOA VISTA DO TUPIM	2010-03-11 00:00:00	\N	\N
249	5	BOM JESUS DA LAPA	2010-03-11 00:00:00	\N	\N
250	5	BOM JESUS DA SERRA	2010-03-11 00:00:00	\N	\N
251	5	BONINAL	2010-03-11 00:00:00	\N	\N
252	5	BONITO	2010-03-11 00:00:00	\N	\N
253	5	BOQUIRA	2010-03-11 00:00:00	\N	\N
254	5	BOTUPORÃ	2010-03-11 00:00:00	\N	\N
255	5	BREJÕES	2010-03-11 00:00:00	\N	\N
256	5	BREJOLÂNDIA	2010-03-11 00:00:00	\N	\N
257	5	BROTAS DE MACAUBAS	2010-03-11 00:00:00	\N	\N
258	5	BRUMADO	2010-03-11 00:00:00	\N	\N
259	5	BUERAREMA	2010-03-11 00:00:00	\N	\N
260	5	BURITIRAMA	2010-03-11 00:00:00	\N	\N
261	5	CAATIBA	2010-03-11 00:00:00	\N	\N
262	5	CABACEIRAS DO PARAGUAÇU	2010-03-11 00:00:00	\N	\N
263	5	CACHOEIRA	2010-03-11 00:00:00	\N	\N
264	5	CACULÉ	2010-03-11 00:00:00	\N	\N
265	5	CAEM	2010-03-11 00:00:00	\N	\N
266	5	CAETANOS	2010-03-11 00:00:00	\N	\N
267	5	CAETITÉ	2010-03-11 00:00:00	\N	\N
268	5	CAFARNAUM	2010-03-11 00:00:00	\N	\N
269	5	CAIRU	2010-03-11 00:00:00	\N	\N
270	5	CALDEIRÃO GRANDE	2010-03-11 00:00:00	\N	\N
271	5	CAMACAN	2010-03-11 00:00:00	\N	\N
272	5	CAMAÇARI	2010-03-11 00:00:00	\N	\N
273	5	CAMAMU	2010-03-11 00:00:00	\N	\N
274	5	CAMPO ALEGRE DE LOURDES	2010-03-11 00:00:00	\N	\N
275	5	CAMPO FORMOSO	2010-03-11 00:00:00	\N	\N
276	5	CANÁPOLIS	2010-03-11 00:00:00	\N	\N
277	5	CANARANA	2010-03-11 00:00:00	\N	\N
278	5	CANAVIEIRAS	2010-03-11 00:00:00	\N	\N
279	5	CANDEAL	2010-03-11 00:00:00	\N	\N
280	5	CANDEIAS	2010-03-11 00:00:00	\N	\N
281	5	CANDIBA	2010-03-11 00:00:00	\N	\N
282	5	CÂNDIDO SALES	2010-03-11 00:00:00	\N	\N
283	5	CANSANÇÃO	2010-03-11 00:00:00	\N	\N
284	5	CANUDOS	2010-03-11 00:00:00	\N	\N
285	5	CAPELA DO ALTO ALEGRE	2010-03-11 00:00:00	\N	\N
286	5	CAPIM GROSSO	2010-03-11 00:00:00	\N	\N
287	5	CARAÍBAS	2010-03-11 00:00:00	\N	\N
288	5	CARAVELAS	2010-03-11 00:00:00	\N	\N
289	5	CARDEAL DA SILVA	2010-03-11 00:00:00	\N	\N
290	5	CARINHANHA	2010-03-11 00:00:00	\N	\N
291	5	CASA NOVA	2010-03-11 00:00:00	\N	\N
292	5	CASTRO ALVES	2010-03-11 00:00:00	\N	\N
293	5	CATOLÂNDIA	2010-03-11 00:00:00	\N	\N
294	5	CATU	2010-03-11 00:00:00	\N	\N
295	5	CATURAMA	2010-03-11 00:00:00	\N	\N
296	5	CENTRAL	2010-03-11 00:00:00	\N	\N
297	5	CHORROCHO	2010-03-11 00:00:00	\N	\N
298	5	CÍCERO DANTAS	2010-03-11 00:00:00	\N	\N
299	5	CIPÓ	2010-03-11 00:00:00	\N	\N
300	5	COARACI	2010-03-11 00:00:00	\N	\N
301	5	COCOS	2010-03-11 00:00:00	\N	\N
302	5	CONCEIÇÃO DA FEIRA	2010-03-11 00:00:00	\N	\N
303	5	CONCEIÇÃO DO ALMEIDA	2010-03-11 00:00:00	\N	\N
304	5	CONCEIÇÃO DO COITÉ	2010-03-11 00:00:00	\N	\N
305	5	CONCEIÇÃO DO JACUÍPE	2010-03-11 00:00:00	\N	\N
306	5	CONDE	2010-03-11 00:00:00	\N	\N
307	5	CONDEUBA	2010-03-11 00:00:00	\N	\N
308	5	CONTENDAS DO SINCORÁ	2010-03-11 00:00:00	\N	\N
309	5	CORAÇÃO DE MARIA	2010-03-11 00:00:00	\N	\N
310	5	CORDEIROS	2010-03-11 00:00:00	\N	\N
311	5	CORIBE	2010-03-11 00:00:00	\N	\N
312	5	CORONEL JOÃO SÁ	2010-03-11 00:00:00	\N	\N
313	5	CORRENTINA	2010-03-11 00:00:00	\N	\N
314	5	COTEGIPE	2010-03-11 00:00:00	\N	\N
315	5	CRAVOLÂNDIA	2010-03-11 00:00:00	\N	\N
316	5	CRISÓPOLIS	2010-03-11 00:00:00	\N	\N
317	5	CRISTÓPOLIS	2010-03-11 00:00:00	\N	\N
318	5	CRUZ DAS ALMAS	2010-03-11 00:00:00	\N	\N
319	5	CURAÇA	2010-03-11 00:00:00	\N	\N
320	5	DARIO MEIRA	2010-03-11 00:00:00	\N	\N
321	5	DIAS D ÁVILA	2010-03-11 00:00:00	\N	\N
322	5	DOM BASÍLIO	2010-03-11 00:00:00	\N	\N
323	5	DOM MACEDO COSTA	2010-03-11 00:00:00	\N	\N
324	5	ELÍSIO MEDRADO	2010-03-11 00:00:00	\N	\N
325	5	ENCRUZILHADA	2010-03-11 00:00:00	\N	\N
326	5	ENTRE RIOS	2010-03-11 00:00:00	\N	\N
327	5	ÉRICO CARDOSO	2010-03-11 00:00:00	\N	\N
328	5	ESPLANADA	2010-03-11 00:00:00	\N	\N
329	5	EUCLIDES DA CUNHA	2010-03-11 00:00:00	\N	\N
330	5	EUNÁPOLIS	2010-03-11 00:00:00	\N	\N
331	5	FÁTIMA	2010-03-11 00:00:00	\N	\N
332	5	FEIRA DA MATA	2010-03-11 00:00:00	\N	\N
333	5	FEIRA DE SANTANA	2010-03-11 00:00:00	\N	\N
334	5	FILADÉLFIA	2010-03-11 00:00:00	\N	\N
335	5	FIRMINO ALVES	2010-03-11 00:00:00	\N	\N
336	5	FLORESTA AZUL	2010-03-11 00:00:00	\N	\N
337	5	FORMOSA DO RIO PRETO	2010-03-11 00:00:00	\N	\N
338	5	GANDU	2010-03-11 00:00:00	\N	\N
339	5	GAVIÃO	2010-03-11 00:00:00	\N	\N
340	5	GENTIO DO OURO	2010-03-11 00:00:00	\N	\N
341	5	GLÓRIA	2010-03-11 00:00:00	\N	\N
342	5	GONGOGI	2010-03-11 00:00:00	\N	\N
343	5	GOVERNADOR MANGABEIRA	2010-03-11 00:00:00	\N	\N
344	5	GUAJERU	2010-03-11 00:00:00	\N	\N
345	5	GUANAMBI	2010-03-11 00:00:00	\N	\N
346	5	GUARATINGA	2010-03-11 00:00:00	\N	\N
347	5	HELIÓPOLIS	2010-03-11 00:00:00	\N	\N
348	5	IAÇU	2010-03-11 00:00:00	\N	\N
349	5	IBIASSUCE	2010-03-11 00:00:00	\N	\N
350	5	IBICARAÍ	2010-03-11 00:00:00	\N	\N
351	5	IBICOARA	2010-03-11 00:00:00	\N	\N
352	5	IBICUÍ	2010-03-11 00:00:00	\N	\N
353	5	IBIPEBA	2010-03-11 00:00:00	\N	\N
354	5	IBIPITANGA	2010-03-11 00:00:00	\N	\N
355	5	IBIQUERA	2010-03-11 00:00:00	\N	\N
356	5	IBIRAPITANGA	2010-03-11 00:00:00	\N	\N
357	5	IBIRAPUÃ	2010-03-11 00:00:00	\N	\N
358	5	IBIRATAIA	2010-03-11 00:00:00	\N	\N
359	5	IBITIARA	2010-03-11 00:00:00	\N	\N
360	5	IBITITA	2010-03-11 00:00:00	\N	\N
361	5	IBOTIRAMA	2010-03-11 00:00:00	\N	\N
362	5	ICHU	2010-03-11 00:00:00	\N	\N
363	5	IGAPORÃ	2010-03-11 00:00:00	\N	\N
364	5	IGRAPIUNA	2010-03-11 00:00:00	\N	\N
365	5	IGUAI	2010-03-11 00:00:00	\N	\N
366	5	ILHÉUS	2010-03-11 00:00:00	\N	\N
367	5	INHAMBUPE	2010-03-11 00:00:00	\N	\N
368	5	IPECAETÁ	2010-03-11 00:00:00	\N	\N
369	5	IPIAU	2010-03-11 00:00:00	\N	\N
370	5	IPIRA	2010-03-11 00:00:00	\N	\N
371	5	IPUPIARA	2010-03-11 00:00:00	\N	\N
372	5	IRAJUBA	2010-03-11 00:00:00	\N	\N
373	5	IRAMAIA	2010-03-11 00:00:00	\N	\N
374	5	IRAQUARA	2010-03-11 00:00:00	\N	\N
375	5	IRARA	2010-03-11 00:00:00	\N	\N
376	5	IRECÊ	2010-03-11 00:00:00	\N	\N
377	5	ITABELA	2010-03-11 00:00:00	\N	\N
378	5	ITABERABA	2010-03-11 00:00:00	\N	\N
379	5	ITABUNA	2010-03-11 00:00:00	\N	\N
380	5	ITACARÉ	2010-03-11 00:00:00	\N	\N
381	5	ITAETE	2010-03-11 00:00:00	\N	\N
382	5	ITAGI	2010-03-11 00:00:00	\N	\N
383	5	ITAGIBA	2010-03-11 00:00:00	\N	\N
384	5	ITAGIMIRIM	2010-03-11 00:00:00	\N	\N
385	5	ITAGUAÇU DA BAHIA	2010-03-11 00:00:00	\N	\N
386	5	ITAJU DO COLÔNIA	2010-03-11 00:00:00	\N	\N
387	5	ITAJUIPE	2010-03-11 00:00:00	\N	\N
388	5	ITAMARAJU	2010-03-11 00:00:00	\N	\N
389	5	ITAMARI	2010-03-11 00:00:00	\N	\N
390	5	ITAMBÉ	2010-03-11 00:00:00	\N	\N
391	5	ITANAGRA	2010-03-11 00:00:00	\N	\N
392	5	ITANHEM	2010-03-11 00:00:00	\N	\N
393	5	ITAPARICA	2010-03-11 00:00:00	\N	\N
394	5	ITAPÉ	2010-03-11 00:00:00	\N	\N
395	5	ITAPEBI	2010-03-11 00:00:00	\N	\N
396	5	ITAPETINGA	2010-03-11 00:00:00	\N	\N
397	5	ITAPICURU	2010-03-11 00:00:00	\N	\N
398	5	ITAPITANGA	2010-03-11 00:00:00	\N	\N
399	5	ITAQUARA	2010-03-11 00:00:00	\N	\N
400	5	ITARANTIM	2010-03-11 00:00:00	\N	\N
401	5	ITATIM	2010-03-11 00:00:00	\N	\N
402	5	ITIRUÇU	2010-03-11 00:00:00	\N	\N
403	5	ITIUBA	2010-03-11 00:00:00	\N	\N
404	5	ITORORÓ	2010-03-11 00:00:00	\N	\N
405	5	ITUAÇU	2010-03-11 00:00:00	\N	\N
406	5	ITUBERA	2010-03-11 00:00:00	\N	\N
407	5	IUIU	2010-03-11 00:00:00	\N	\N
408	5	JABORANDI	2010-03-11 00:00:00	\N	\N
409	5	JACARACI	2010-03-11 00:00:00	\N	\N
410	5	JACOBINA	2010-03-11 00:00:00	\N	\N
411	5	JAGUAQUARA	2010-03-11 00:00:00	\N	\N
412	5	JAGUARARI	2010-03-11 00:00:00	\N	\N
413	5	JAGUARIPE	2010-03-11 00:00:00	\N	\N
414	5	JANDAÍRA	2010-03-11 00:00:00	\N	\N
415	5	JEQUIÉ	2010-03-11 00:00:00	\N	\N
416	5	JEREMOABO	2010-03-11 00:00:00	\N	\N
417	5	JIQUIRIÇA	2010-03-11 00:00:00	\N	\N
418	5	JITAUNA	2010-03-11 00:00:00	\N	\N
419	5	JOÃO DOURADO	2010-03-11 00:00:00	\N	\N
420	5	JUAZEIRO	2010-03-11 00:00:00	\N	\N
421	5	JUCURUÇU	2010-03-11 00:00:00	\N	\N
422	5	JUSSARA	2010-03-11 00:00:00	\N	\N
423	5	JUSSARI	2010-03-11 00:00:00	\N	\N
424	5	JUSSIAPE	2010-03-11 00:00:00	\N	\N
425	5	LAFAIETE COUTINHO	2010-03-11 00:00:00	\N	\N
426	5	LAGOA REAL	2010-03-11 00:00:00	\N	\N
427	5	LAJE	2010-03-11 00:00:00	\N	\N
428	5	LAJEDÃO	2010-03-11 00:00:00	\N	\N
429	5	LAJEDINHO	2010-03-11 00:00:00	\N	\N
430	5	LAJEDO DO TABOCAL	2010-03-11 00:00:00	\N	\N
431	5	LAMARÃO	2010-03-11 00:00:00	\N	\N
432	5	LAPÃO	2010-03-11 00:00:00	\N	\N
433	5	LAURO DE FREITAS	2010-03-11 00:00:00	\N	\N
434	5	LENÇOIS	2010-03-11 00:00:00	\N	\N
435	5	LICINIO DE ALMEIDA	2010-03-11 00:00:00	\N	\N
436	5	LIVRAMENTO DE NOSSA SENHORA	2010-03-11 00:00:00	\N	\N
437	5	LUIS EDUARDO MAGALHÃES	2010-03-11 00:00:00	\N	\N
438	5	MACAJUBA	2010-03-11 00:00:00	\N	\N
439	5	MACARANI	2010-03-11 00:00:00	\N	\N
440	5	MACAUBAS	2010-03-11 00:00:00	\N	\N
441	5	MACURURE	2010-03-11 00:00:00	\N	\N
442	5	MADRE DE DEUS	2010-03-11 00:00:00	\N	\N
443	5	MAETINGA	2010-03-11 00:00:00	\N	\N
444	5	MAIQUINIQUE	2010-03-11 00:00:00	\N	\N
445	5	MAIRI	2010-03-11 00:00:00	\N	\N
446	5	MALHADA	2010-03-11 00:00:00	\N	\N
447	5	MALHADA DE PEDRAS	2010-03-11 00:00:00	\N	\N
448	5	MANOEL VITORINO	2010-03-11 00:00:00	\N	\N
449	5	MANSIDÃO	2010-03-11 00:00:00	\N	\N
450	5	MARACAS	2010-03-11 00:00:00	\N	\N
451	5	MARAGOGIPE	2010-03-11 00:00:00	\N	\N
452	5	MARAU	2010-03-11 00:00:00	\N	\N
453	5	MARCIONÍLIO SOUZA	2010-03-11 00:00:00	\N	\N
454	5	MASCOTE	2010-03-11 00:00:00	\N	\N
455	5	MATA DE SÃO JOÃO	2010-03-11 00:00:00	\N	\N
456	5	MATINA	2010-03-11 00:00:00	\N	\N
457	5	MEDEIROS NETO	2010-03-11 00:00:00	\N	\N
458	5	MIGUEL CALMON	2010-03-11 00:00:00	\N	\N
459	5	MILAGRES	2010-03-11 00:00:00	\N	\N
460	5	MIRANGABA	2010-03-11 00:00:00	\N	\N
461	5	MIRANTE	2010-03-11 00:00:00	\N	\N
462	5	MONTE SANTO	2010-03-11 00:00:00	\N	\N
463	5	MORPARA	2010-03-11 00:00:00	\N	\N
464	5	MORRO DO CHAPÉU	2010-03-11 00:00:00	\N	\N
465	5	MORTUGABA	2010-03-11 00:00:00	\N	\N
466	5	MUCUGE	2010-03-11 00:00:00	\N	\N
467	5	MUCURI	2010-03-11 00:00:00	\N	\N
468	5	MULUNGU DO MORRO	2010-03-11 00:00:00	\N	\N
469	5	MUNDO NOVO	2010-03-11 00:00:00	\N	\N
470	5	MUNIZ FERREIRA	2010-03-11 00:00:00	\N	\N
471	5	MUQUEM DE SÃO FRANCISCO	2010-03-11 00:00:00	\N	\N
472	5	MURITIBA	2010-03-11 00:00:00	\N	\N
473	5	MUTUÍPE	2010-03-11 00:00:00	\N	\N
474	5	NAZARÉ	2010-03-11 00:00:00	\N	\N
475	5	NILO PEÇANHA	2010-03-11 00:00:00	\N	\N
476	5	NORDESTINA	2010-03-11 00:00:00	\N	\N
477	5	NOVA CANAÃ	2010-03-11 00:00:00	\N	\N
478	5	NOVA FÁTIMA	2010-03-11 00:00:00	\N	\N
479	5	NOVA IBIA	2010-03-11 00:00:00	\N	\N
480	5	NOVA ITARANA	2010-03-11 00:00:00	\N	\N
481	5	NOVA REDENÇÃO	2010-03-11 00:00:00	\N	\N
482	5	NOVA SOURÉ	2010-03-11 00:00:00	\N	\N
483	5	NOVA VIÇOSA	2010-03-11 00:00:00	\N	\N
484	5	NOVO HORIZONTE	2010-03-11 00:00:00	\N	\N
485	5	NOVO TRIUNFO	2010-03-11 00:00:00	\N	\N
486	5	OLINDINA	2010-03-11 00:00:00	\N	\N
487	5	OLIVEIRA DOS BREJINHOS	2010-03-11 00:00:00	\N	\N
488	5	OURIÇANGAS	2010-03-11 00:00:00	\N	\N
489	5	OUROLÂNDIA	2010-03-11 00:00:00	\N	\N
490	5	PALMAS DE MONTE ALTO	2010-03-11 00:00:00	\N	\N
491	5	PALMEIRAS	2010-03-11 00:00:00	\N	\N
492	5	PARAMIRIM	2010-03-11 00:00:00	\N	\N
493	5	PARATINGA	2010-03-11 00:00:00	\N	\N
494	5	PARIPIRANGA	2010-03-11 00:00:00	\N	\N
495	5	PAU BRASIL	2010-03-11 00:00:00	\N	\N
496	5	PAULO AFONSO	2010-03-11 00:00:00	\N	\N
497	5	PÉ DE SERRA	2010-03-11 00:00:00	\N	\N
498	5	PEDRÃO	2010-03-11 00:00:00	\N	\N
499	5	PEDRO ALEXANDRE	2010-03-11 00:00:00	\N	\N
500	5	PIATÃ	2010-03-11 00:00:00	\N	\N
501	5	PILÃO ARCADO	2010-03-11 00:00:00	\N	\N
502	5	PINDAI	2010-03-11 00:00:00	\N	\N
503	5	PINDOBAÇU	2010-03-11 00:00:00	\N	\N
504	5	PINTADAS	2010-03-11 00:00:00	\N	\N
505	5	PIRAÍ DO NORTE	2010-03-11 00:00:00	\N	\N
506	5	PIRIPA	2010-03-11 00:00:00	\N	\N
507	5	PIRITIBA	2010-03-11 00:00:00	\N	\N
508	5	PLANALTINO	2010-03-11 00:00:00	\N	\N
509	5	PLANALTO	2010-03-11 00:00:00	\N	\N
510	5	POÇÕES	2010-03-11 00:00:00	\N	\N
511	5	POJUCA	2010-03-11 00:00:00	\N	\N
512	5	PONTO NOVO	2010-03-11 00:00:00	\N	\N
513	5	PORTO SEGURO	2010-03-11 00:00:00	\N	\N
514	5	POTIRAGUA	2010-03-11 00:00:00	\N	\N
515	5	PRADO	2010-03-11 00:00:00	\N	\N
516	5	PRESIDENTE DUTRA	2010-03-11 00:00:00	\N	\N
517	5	PRESIDENTE JÂNIO QUADROS	2010-03-11 00:00:00	\N	\N
518	5	PRESIDENTE TANCREDO NEVES	2010-03-11 00:00:00	\N	\N
519	5	QUEIMADAS	2010-03-11 00:00:00	\N	\N
520	5	QUIJINGUE	2010-03-11 00:00:00	\N	\N
521	5	QUIXABEIRA	2010-03-11 00:00:00	\N	\N
522	5	RAFAEL JAMBEIRO	2010-03-11 00:00:00	\N	\N
523	5	REMANSO	2010-03-11 00:00:00	\N	\N
524	5	RETIROLÂNDIA	2010-03-11 00:00:00	\N	\N
525	5	RIACHÃO DAS NEVES	2010-03-11 00:00:00	\N	\N
526	5	RIACHÃO DO JACUÍPE	2010-03-11 00:00:00	\N	\N
527	5	RIACHO DE SANTANA	2010-03-11 00:00:00	\N	\N
528	5	RIBEIRA DO AMPARO	2010-03-11 00:00:00	\N	\N
529	5	RIBEIRA DO POMBAL	2010-03-11 00:00:00	\N	\N
530	5	RIBEIRÃO DO LARGO	2010-03-11 00:00:00	\N	\N
531	5	RIO DE CONTAS	2010-03-11 00:00:00	\N	\N
532	5	RIO DO ANTÔNIO	2010-03-11 00:00:00	\N	\N
533	5	RIO DO PIRES	2010-03-11 00:00:00	\N	\N
534	5	RIO REAL	2010-03-11 00:00:00	\N	\N
535	5	RODELAS	2010-03-11 00:00:00	\N	\N
536	5	RUY BARBOSA	2010-03-11 00:00:00	\N	\N
537	5	SALINAS DA MARGARIDA	2010-03-11 00:00:00	\N	\N
539	5	SANTA BÁRBARA	2010-03-11 00:00:00	\N	\N
540	5	SANTA BRÍGIDA	2010-03-11 00:00:00	\N	\N
541	5	SANTA CRUZ CABRÁLIA	2010-03-11 00:00:00	\N	\N
542	5	SANTA CRUZ DA VITÓRIA	2010-03-11 00:00:00	\N	\N
543	5	SANTA INÊS	2010-03-11 00:00:00	\N	\N
544	5	SANTA LUZIA	2010-03-11 00:00:00	\N	\N
545	5	SANTA MARIA DA VITÓRIA	2010-03-11 00:00:00	\N	\N
546	5	SANTA RITA DE CÁSSIA	2010-03-11 00:00:00	\N	\N
547	5	SANTA TERESINHA	2010-03-11 00:00:00	\N	\N
548	5	SANTALUZ	2010-03-11 00:00:00	\N	\N
549	5	SANTANA	2010-03-11 00:00:00	\N	\N
550	5	SANTANÓPOLIS	2010-03-11 00:00:00	\N	\N
551	5	SANTO AMARO	2010-03-11 00:00:00	\N	\N
552	5	SANTO ANTÔNIO DE JESUS	2010-03-11 00:00:00	\N	\N
553	5	SANTO ESTEVÃO	2010-03-11 00:00:00	\N	\N
554	5	SÃO DESIDÉRIO	2010-03-11 00:00:00	\N	\N
555	5	SÃO DOMINGOS	2010-03-11 00:00:00	\N	\N
556	5	SÃO FELIPE	2010-03-11 00:00:00	\N	\N
557	5	SÃO FÉLIX	2010-03-11 00:00:00	\N	\N
558	5	SÃO FÉLIX DO CORIBE	2010-03-11 00:00:00	\N	\N
559	5	SÃO FRANCISCO DO CONDE	2010-03-11 00:00:00	\N	\N
560	5	SÃO GABRIEL	2010-03-11 00:00:00	\N	\N
561	5	SÃO GONÇALO DOS CAMPOS	2010-03-11 00:00:00	\N	\N
562	5	SÃO JOSÉ DA VITÓRIA	2010-03-11 00:00:00	\N	\N
563	5	SÃO JOSÉ DO JACUÍPE	2010-03-11 00:00:00	\N	\N
564	5	SÃO MIGUEL DAS MATAS	2010-03-11 00:00:00	\N	\N
565	5	SÃO SEBASTIÃO DO PASSE	2010-03-11 00:00:00	\N	\N
566	5	SAPEAÇU	2010-03-11 00:00:00	\N	\N
567	5	SÁTIRO DIAS	2010-03-11 00:00:00	\N	\N
568	5	SAUBARA	2010-03-11 00:00:00	\N	\N
569	5	SAÚDE	2010-03-11 00:00:00	\N	\N
570	5	SEABRA	2010-03-11 00:00:00	\N	\N
571	5	SEBASTIÃO LARANJEIRAS	2010-03-11 00:00:00	\N	\N
572	5	SENHOR DO BONFIM	2010-03-11 00:00:00	\N	\N
573	5	SENTO SÉ	2010-03-11 00:00:00	\N	\N
574	5	SERRA DO RAMALHO	2010-03-11 00:00:00	\N	\N
575	5	SERRA DOURADA	2010-03-11 00:00:00	\N	\N
576	5	SERRA PRETA	2010-03-11 00:00:00	\N	\N
577	5	SERRINHA	2010-03-11 00:00:00	\N	\N
578	5	SERROLÂNDIA	2010-03-11 00:00:00	\N	\N
579	5	SIMÕES FILHO	2010-03-11 00:00:00	\N	\N
580	5	SÍTIO DO MATO	2010-03-11 00:00:00	\N	\N
581	5	SÍTIO DO QUINTO	2010-03-11 00:00:00	\N	\N
582	5	SOBRADINHO	2010-03-11 00:00:00	\N	\N
583	5	SOUTO SOARES	2010-03-11 00:00:00	\N	\N
584	5	TABOCAS DO BREJO VELHO	2010-03-11 00:00:00	\N	\N
585	5	TANHAÇU	2010-03-11 00:00:00	\N	\N
586	5	TANQUE NOVO	2010-03-11 00:00:00	\N	\N
587	5	TANQUINHO	2010-03-11 00:00:00	\N	\N
588	5	TAPEROÁ	2010-03-11 00:00:00	\N	\N
589	5	TAPIRAMUTA	2010-03-11 00:00:00	\N	\N
590	5	TEIXEIRA DE FREITAS	2010-03-11 00:00:00	\N	\N
591	5	TEODORO SAMPAIO	2010-03-11 00:00:00	\N	\N
592	5	TEOFILÂNDIA	2010-03-11 00:00:00	\N	\N
593	5	TEOLÂNDIA	2010-03-11 00:00:00	\N	\N
594	5	TERRA NOVA	2010-03-11 00:00:00	\N	\N
595	5	TREMEDAL	2010-03-11 00:00:00	\N	\N
596	5	TUCANO	2010-03-11 00:00:00	\N	\N
597	5	UAUÁ	2010-03-11 00:00:00	\N	\N
598	5	UBAIRA	2010-03-11 00:00:00	\N	\N
599	5	UBAITABA	2010-03-11 00:00:00	\N	\N
600	5	UBATÃ	2010-03-11 00:00:00	\N	\N
601	5	UIBAI	2010-03-11 00:00:00	\N	\N
602	5	UMBURANAS	2010-03-11 00:00:00	\N	\N
603	5	UNA	2010-03-11 00:00:00	\N	\N
604	5	URANDI	2010-03-11 00:00:00	\N	\N
605	5	URUÇUCA	2010-03-11 00:00:00	\N	\N
606	5	UTINGA	2010-03-11 00:00:00	\N	\N
607	5	VALENÇA	2010-03-11 00:00:00	\N	\N
608	5	VALENTE	2010-03-11 00:00:00	\N	\N
609	5	VÁRZEA DA ROÇA	2010-03-11 00:00:00	\N	\N
610	5	VÁRZEA DO POÇO	2010-03-11 00:00:00	\N	\N
611	5	VÁRZEA NOVA	2010-03-11 00:00:00	\N	\N
612	5	VARZEDO	2010-03-11 00:00:00	\N	\N
613	5	VERA CRUZ	2010-03-11 00:00:00	\N	\N
614	5	VEREDA	2010-03-11 00:00:00	\N	\N
615	5	VITÓRIA DA CONQUISTA	2010-03-11 00:00:00	\N	\N
616	5	WAGNER	2010-03-11 00:00:00	\N	\N
617	5	WANDERLEY	2010-03-11 00:00:00	\N	\N
618	5	WENCESLAU GUIMARÃES	2010-03-11 00:00:00	\N	\N
619	5	XIQUE-XIQUE	2010-03-11 00:00:00	\N	\N
620	6	ABAIARA	2010-03-11 00:00:00	\N	\N
621	6	ACARAPE	2010-03-11 00:00:00	\N	\N
622	6	ACARAU	2010-03-11 00:00:00	\N	\N
623	6	ACOPIARA	2010-03-11 00:00:00	\N	\N
624	6	AIUABA	2010-03-11 00:00:00	\N	\N
625	6	ALCANTARAS	2010-03-11 00:00:00	\N	\N
626	6	ALTANEIRA	2010-03-11 00:00:00	\N	\N
627	6	ALTO SANTO	2010-03-11 00:00:00	\N	\N
628	6	AMONTADA	2010-03-11 00:00:00	\N	\N
629	6	ANTONINA DO NORTE	2010-03-11 00:00:00	\N	\N
630	6	APUIARES	2010-03-11 00:00:00	\N	\N
631	6	AQUIRAZ	2010-03-11 00:00:00	\N	\N
632	6	ARACATI	2010-03-11 00:00:00	\N	\N
633	6	ARACOIABA	2010-03-11 00:00:00	\N	\N
634	6	ARARENDA	2010-03-11 00:00:00	\N	\N
635	6	ARARIPE	2010-03-11 00:00:00	\N	\N
636	6	ARATUBA	2010-03-11 00:00:00	\N	\N
637	6	ARNEIROZ	2010-03-11 00:00:00	\N	\N
638	6	ASSARÉ	2010-03-11 00:00:00	\N	\N
639	6	AURORA	2010-03-11 00:00:00	\N	\N
640	6	BAIXIO	2010-03-11 00:00:00	\N	\N
641	6	BANABUIU	2010-03-11 00:00:00	\N	\N
642	6	BARBALHA	2010-03-11 00:00:00	\N	\N
643	6	BARREIRA	2010-03-11 00:00:00	\N	\N
644	6	BARRO	2010-03-11 00:00:00	\N	\N
645	6	BARROQUINHA	2010-03-11 00:00:00	\N	\N
646	6	BATURITÉ	2010-03-11 00:00:00	\N	\N
647	6	BEBERIBE	2010-03-11 00:00:00	\N	\N
648	6	BELA CRUZ	2010-03-11 00:00:00	\N	\N
649	6	BOA VIAGEM	2010-03-11 00:00:00	\N	\N
650	6	BREJO SANTO	2010-03-11 00:00:00	\N	\N
651	6	CAMOCIM	2010-03-11 00:00:00	\N	\N
652	6	CAMPOS SALES	2010-03-11 00:00:00	\N	\N
653	6	CANINDÉ	2010-03-11 00:00:00	\N	\N
654	6	CAPISTRANO	2010-03-11 00:00:00	\N	\N
655	6	CARIDADE	2010-03-11 00:00:00	\N	\N
656	6	CARIRE	2010-03-11 00:00:00	\N	\N
657	6	CARIRIAÇU	2010-03-11 00:00:00	\N	\N
658	6	CARIUS	2010-03-11 00:00:00	\N	\N
659	6	CARNAUBAL	2010-03-11 00:00:00	\N	\N
660	6	CASCAVEL	2010-03-11 00:00:00	\N	\N
661	6	CATARINA	2010-03-11 00:00:00	\N	\N
662	6	CATUNDA	2010-03-11 00:00:00	\N	\N
663	6	CAUCAIA	2010-03-11 00:00:00	\N	\N
664	6	CEDRO	2010-03-11 00:00:00	\N	\N
665	6	CHAVAL	2010-03-11 00:00:00	\N	\N
666	6	CHORO	2010-03-11 00:00:00	\N	\N
667	6	CHOROZINHO	2010-03-11 00:00:00	\N	\N
668	6	COREAU	2010-03-11 00:00:00	\N	\N
669	6	CRATEÚS	2010-03-11 00:00:00	\N	\N
670	6	CRATO	2010-03-11 00:00:00	\N	\N
671	6	CROATA	2010-03-11 00:00:00	\N	\N
672	6	CRUZ	2010-03-11 00:00:00	\N	\N
673	6	DEPUTADO IRAPUAN RIBEIRO	2010-03-11 00:00:00	\N	\N
674	6	ERERE	2010-03-11 00:00:00	\N	\N
675	6	EUSÉBIO	2010-03-11 00:00:00	\N	\N
676	6	FARIAS BRITO	2010-03-11 00:00:00	\N	\N
677	6	FORQUILHA	2010-03-11 00:00:00	\N	\N
678	6	FORTALEZA	2010-03-11 00:00:00	\N	\N
679	6	FORTIM	2010-03-11 00:00:00	\N	\N
680	6	FRECHEIRINHA	2010-03-11 00:00:00	\N	\N
681	6	GENERAL SAMPAIO	2010-03-11 00:00:00	\N	\N
682	6	GRAÇA	2010-03-11 00:00:00	\N	\N
683	6	GRANJA	2010-03-11 00:00:00	\N	\N
684	6	GRANJEIRO	2010-03-11 00:00:00	\N	\N
685	6	GROAíRAS	2010-03-11 00:00:00	\N	\N
686	6	GUAIUBA	2010-03-11 00:00:00	\N	\N
687	6	GUARACIABA DO NORTE	2010-03-11 00:00:00	\N	\N
688	6	GUARAMIRANGA	2010-03-11 00:00:00	\N	\N
689	6	HIDROLÂNDIA	2010-03-11 00:00:00	\N	\N
690	6	HORIZONTE	2010-03-11 00:00:00	\N	\N
691	6	IBARETAMA	2010-03-11 00:00:00	\N	\N
692	6	IBIAPINA	2010-03-11 00:00:00	\N	\N
693	6	IBICUITINGA	2010-03-11 00:00:00	\N	\N
694	6	ICAPUI	2010-03-11 00:00:00	\N	\N
695	6	ICÓ	2010-03-11 00:00:00	\N	\N
696	6	IGUATU	2010-03-11 00:00:00	\N	\N
697	6	INDEPENDÊNCIA	2010-03-11 00:00:00	\N	\N
698	6	IPAPORANGA	2010-03-11 00:00:00	\N	\N
699	6	IPAUMIRIM	2010-03-11 00:00:00	\N	\N
700	6	IPU	2010-03-11 00:00:00	\N	\N
701	6	IPUEIRAS	2010-03-11 00:00:00	\N	\N
702	6	IRACEMA	2010-03-11 00:00:00	\N	\N
703	6	IRAUÇUBA	2010-03-11 00:00:00	\N	\N
704	6	ITAIÇABA	2010-03-11 00:00:00	\N	\N
705	6	ITAITINGA	2010-03-11 00:00:00	\N	\N
706	6	ITAPAGÉ	2010-03-11 00:00:00	\N	\N
707	6	ITAPIPOCA	2010-03-11 00:00:00	\N	\N
708	6	ITAPIUNA	2010-03-11 00:00:00	\N	\N
709	6	ITAREMA	2010-03-11 00:00:00	\N	\N
710	6	ITATIRA	2010-03-11 00:00:00	\N	\N
711	6	JAGUARETAMA	2010-03-11 00:00:00	\N	\N
712	6	JAGUARIBARA	2010-03-11 00:00:00	\N	\N
713	6	JAGUARIBE	2010-03-11 00:00:00	\N	\N
714	6	JAGUARUANA	2010-03-11 00:00:00	\N	\N
715	6	JARDIM	2010-03-11 00:00:00	\N	\N
716	6	JATI	2010-03-11 00:00:00	\N	\N
717	6	JIJOCA DE JERICOACOARA	2010-03-11 00:00:00	\N	\N
718	6	JUAZEIRO DO NORTE	2010-03-11 00:00:00	\N	\N
719	6	JUCAS	2010-03-11 00:00:00	\N	\N
720	6	LAVRAS DA MANGABEIRA	2010-03-11 00:00:00	\N	\N
721	6	LIMOEIRO DO NORTE	2010-03-11 00:00:00	\N	\N
722	6	MADALENA	2010-03-11 00:00:00	\N	\N
723	6	MARACANAU	2010-03-11 00:00:00	\N	\N
724	6	MARANGUAPE	2010-03-11 00:00:00	\N	\N
725	6	MARCO	2010-03-11 00:00:00	\N	\N
726	6	MARTINÓPOLE	2010-03-11 00:00:00	\N	\N
727	6	MASSAPÊ	2010-03-11 00:00:00	\N	\N
728	6	MAURITI	2010-03-11 00:00:00	\N	\N
729	6	MERUOCA	2010-03-11 00:00:00	\N	\N
730	6	MILAGRES	2010-03-11 00:00:00	\N	\N
731	6	MILHÃ	2010-03-11 00:00:00	\N	\N
732	6	MIRAIMA	2010-03-11 00:00:00	\N	\N
733	6	MISSÃO VELHA	2010-03-11 00:00:00	\N	\N
734	6	MOMBAÇA	2010-03-11 00:00:00	\N	\N
735	6	MONSENHOR TABOSA	2010-03-11 00:00:00	\N	\N
736	6	MORADA NOVA	2010-03-11 00:00:00	\N	\N
737	6	MORAUJO	2010-03-11 00:00:00	\N	\N
738	6	MORRINHOS	2010-03-11 00:00:00	\N	\N
739	6	MUCAMBO	2010-03-11 00:00:00	\N	\N
740	6	MULUNGU	2010-03-11 00:00:00	\N	\N
741	6	NOVA OLINDA	2010-03-11 00:00:00	\N	\N
742	6	NOVA RUSSAS	2010-03-11 00:00:00	\N	\N
743	6	NOVO ORIENTE	2010-03-11 00:00:00	\N	\N
744	6	OCARA	2010-03-11 00:00:00	\N	\N
745	6	ORÓS	2010-03-11 00:00:00	\N	\N
746	6	PACAJUS	2010-03-11 00:00:00	\N	\N
747	6	PACATUBA	2010-03-11 00:00:00	\N	\N
748	6	PACOTI	2010-03-11 00:00:00	\N	\N
749	6	PACUJA	2010-03-11 00:00:00	\N	\N
750	6	PALHANO	2010-03-11 00:00:00	\N	\N
751	6	PALMACIA	2010-03-11 00:00:00	\N	\N
752	6	PARACURU	2010-03-11 00:00:00	\N	\N
753	6	PARAIPABA	2010-03-11 00:00:00	\N	\N
754	6	PARAMBU	2010-03-11 00:00:00	\N	\N
755	6	PARAMOTI	2010-03-11 00:00:00	\N	\N
756	6	PEDRA BRANCA	2010-03-11 00:00:00	\N	\N
757	6	PENA FORTE	2010-03-11 00:00:00	\N	\N
758	6	PENTECOSTE	2010-03-11 00:00:00	\N	\N
759	6	PEREIRO	2010-03-11 00:00:00	\N	\N
760	6	PINDORETAMA	2010-03-11 00:00:00	\N	\N
761	6	PIQUET CARNEIRO	2010-03-11 00:00:00	\N	\N
762	6	PIRES FERREIRA	2010-03-11 00:00:00	\N	\N
763	6	PORANGA	2010-03-11 00:00:00	\N	\N
764	6	PORTEIRAS	2010-03-11 00:00:00	\N	\N
765	6	POTENGI	2010-03-11 00:00:00	\N	\N
766	6	POTIRETAMA	2010-03-11 00:00:00	\N	\N
767	6	QUITERIANÓPOLIS	2010-03-11 00:00:00	\N	\N
768	6	QUIXADÁ	2010-03-11 00:00:00	\N	\N
769	6	QUIXELO	2010-03-11 00:00:00	\N	\N
770	6	QUIXERAMOBIM	2010-03-11 00:00:00	\N	\N
771	6	QUIXERE	2010-03-11 00:00:00	\N	\N
772	6	REDENÇÃO	2010-03-11 00:00:00	\N	\N
773	6	RERIUTABA	2010-03-11 00:00:00	\N	\N
774	6	RUSSAS	2010-03-11 00:00:00	\N	\N
775	6	SABOEIRO	2010-03-11 00:00:00	\N	\N
776	6	SALITRE	2010-03-11 00:00:00	\N	\N
777	6	SANTA QUITÉRIA	2010-03-11 00:00:00	\N	\N
778	6	SANTANA DO ACARAU	2010-03-11 00:00:00	\N	\N
779	6	SANTANA DO CARIRI	2010-03-11 00:00:00	\N	\N
780	6	SÃO BENEDITO	2010-03-11 00:00:00	\N	\N
781	6	SÃO GONÇALO DO AMARANTE	2010-03-11 00:00:00	\N	\N
782	6	SÃO JOÃO DO JAGUARIBE	2010-03-11 00:00:00	\N	\N
783	6	SÃO LUIZ DO CURU	2010-03-11 00:00:00	\N	\N
784	6	SENADOR POMPEU	2010-03-11 00:00:00	\N	\N
785	6	SENADOR SÁ	2010-03-11 00:00:00	\N	\N
786	6	SOBRAL	2010-03-11 00:00:00	\N	\N
787	6	SOLONÓPOLE	2010-03-11 00:00:00	\N	\N
788	6	TABULEIRO DO NORTE	2010-03-11 00:00:00	\N	\N
789	6	TAMBORIL	2010-03-11 00:00:00	\N	\N
790	6	TARRAFAS	2010-03-11 00:00:00	\N	\N
791	6	TAUÁ	2010-03-11 00:00:00	\N	\N
792	6	TEJUÇUOCA	2010-03-11 00:00:00	\N	\N
793	6	TIANGUA	2010-03-11 00:00:00	\N	\N
794	6	TRAIRI	2010-03-11 00:00:00	\N	\N
795	6	TURURU	2010-03-11 00:00:00	\N	\N
796	6	UBAJARA	2010-03-11 00:00:00	\N	\N
797	6	UMARI	2010-03-11 00:00:00	\N	\N
798	6	UMIRIM	2010-03-11 00:00:00	\N	\N
799	6	URUBURETAMA	2010-03-11 00:00:00	\N	\N
800	6	URUOCA	2010-03-11 00:00:00	\N	\N
801	6	VARJOTA	2010-03-11 00:00:00	\N	\N
802	6	VÁRZEA ALEGRE	2010-03-11 00:00:00	\N	\N
803	6	VIÇOSA DO CEARÁ	2010-03-11 00:00:00	\N	\N
804	7	BRASÍLIA	2010-03-11 00:00:00	\N	\N
805	8	AFONSO CLÁUDIO	2010-03-11 00:00:00	\N	\N
806	8	ÁGUA DOCE DO NORTE	2010-03-11 00:00:00	\N	\N
807	8	ÁGUIA BRANCA	2010-03-11 00:00:00	\N	\N
808	8	ALEGRE	2010-03-11 00:00:00	\N	\N
809	8	ALFREDO CHAVES	2010-03-11 00:00:00	\N	\N
810	8	ALTO RIO NOVO	2010-03-11 00:00:00	\N	\N
811	8	ANCHIETA	2010-03-11 00:00:00	\N	\N
812	8	APIACÁ	2010-03-11 00:00:00	\N	\N
813	8	ARACRUZ	2010-03-11 00:00:00	\N	\N
814	8	ATILIO VIVÁCQUA	2010-03-11 00:00:00	\N	\N
815	8	BAIXO GUANDU	2010-03-11 00:00:00	\N	\N
816	8	BARRA DE SÃO FRANCISCO	2010-03-11 00:00:00	\N	\N
817	8	BOA ESPERANÇA	2010-03-11 00:00:00	\N	\N
818	8	BOM JESUS DO NORTE	2010-03-11 00:00:00	\N	\N
819	8	BREJETUBA	2010-03-11 00:00:00	\N	\N
820	8	CACHOEIRO DO ITAPEMIRIM	2010-03-11 00:00:00	\N	\N
821	8	CARIACICA	2010-03-11 00:00:00	\N	\N
822	8	CASTELO	2010-03-11 00:00:00	\N	\N
823	8	COLATINA	2010-03-11 00:00:00	\N	\N
824	8	CONCEIÇÃO DA BARRA	2010-03-11 00:00:00	\N	\N
825	8	CONCEIÇÃO DO CASTELO	2010-03-11 00:00:00	\N	\N
826	8	DIVINO DE SÃO LOURENÇO	2010-03-11 00:00:00	\N	\N
827	8	DOMINGOS MARTINS	2010-03-11 00:00:00	\N	\N
828	8	DORES DO RIO PRETO	2010-03-11 00:00:00	\N	\N
829	8	ECOPORANGA	2010-03-11 00:00:00	\N	\N
830	8	FUNDÃO	2010-03-11 00:00:00	\N	\N
831	8	GOVERNADOR LINDENBERG	2010-03-11 00:00:00	\N	\N
832	8	GUAÇUÍ	2010-03-11 00:00:00	\N	\N
833	8	GUARAPARI	2010-03-11 00:00:00	\N	\N
834	8	IBATIBA	2010-03-11 00:00:00	\N	\N
835	8	IBIRAÇU	2010-03-11 00:00:00	\N	\N
836	8	IBITIRAMA	2010-03-11 00:00:00	\N	\N
837	8	ICONHA	2010-03-11 00:00:00	\N	\N
838	8	IRUPI	2010-03-11 00:00:00	\N	\N
839	8	ITAGUAÇU	2010-03-11 00:00:00	\N	\N
840	8	ITAPEMIRIM	2010-03-11 00:00:00	\N	\N
841	8	ITARANA	2010-03-11 00:00:00	\N	\N
842	8	IÚNA	2010-03-11 00:00:00	\N	\N
843	8	JAGUARÉ	2010-03-11 00:00:00	\N	\N
844	8	JERÔNIMO MONTEIRO	2010-03-11 00:00:00	\N	\N
845	8	JOÃO NEIVA	2010-03-11 00:00:00	\N	\N
846	8	LARANJA DA TERRA	2010-03-11 00:00:00	\N	\N
847	8	LINHARES	2010-03-11 00:00:00	\N	\N
848	8	MANTENÓPOLIS	2010-03-11 00:00:00	\N	\N
849	8	MARATAÍZES	2010-03-11 00:00:00	\N	\N
850	8	MARECHAL FLORIANO	2010-03-11 00:00:00	\N	\N
851	8	MARILÂNDIA	2010-03-11 00:00:00	\N	\N
852	8	MIMOSO DO SUL	2010-03-11 00:00:00	\N	\N
853	8	MONTANHA	2010-03-11 00:00:00	\N	\N
854	8	MUCURICI	2010-03-11 00:00:00	\N	\N
855	8	MUNIZ FREIRE	2010-03-11 00:00:00	\N	\N
856	8	MUQUI	2010-03-11 00:00:00	\N	\N
857	8	NOVA VENÉCIA	2010-03-11 00:00:00	\N	\N
858	8	PANCAS	2010-03-11 00:00:00	\N	\N
859	8	PEDRO CANÁRIO	2010-03-11 00:00:00	\N	\N
860	8	PINHEIROS	2010-03-11 00:00:00	\N	\N
861	8	PIÚMA	2010-03-11 00:00:00	\N	\N
862	8	PONTO BELO	2010-03-11 00:00:00	\N	\N
863	8	PRESIDENTE KENNEDY	2010-03-11 00:00:00	\N	\N
864	8	RIO BANANAL	2010-03-11 00:00:00	\N	\N
865	8	RIO NOVO DO SUL	2010-03-11 00:00:00	\N	\N
866	8	SANTA LEOPOLDINA	2010-03-11 00:00:00	\N	\N
867	8	SANTA MARIA DE JETIBÁ	2010-03-11 00:00:00	\N	\N
868	8	SANTA TERESA	2010-03-11 00:00:00	\N	\N
869	8	SÃO DOMINGOS DO NORTE	2010-03-11 00:00:00	\N	\N
870	8	SÃO GABRIEL DA PALHA	2010-03-11 00:00:00	\N	\N
871	8	SÃO JOSÉ DO CALÇADO	2010-03-11 00:00:00	\N	\N
872	8	SÃO MATEUS	2010-03-11 00:00:00	\N	\N
873	8	SÃO ROQUE DO CANAÃ	2010-03-11 00:00:00	\N	\N
874	8	SERRA	2010-03-11 00:00:00	\N	\N
875	8	SOORETAMA	2010-03-11 00:00:00	\N	\N
876	8	VARGEM ALTA	2010-03-11 00:00:00	\N	\N
877	8	VENDA NOVA DO IMIGRANTE	2010-03-11 00:00:00	\N	\N
878	8	VIANA	2010-03-11 00:00:00	\N	\N
879	8	VILA PAVÃO	2010-03-11 00:00:00	\N	\N
880	8	VILA VALÉRIO	2010-03-11 00:00:00	\N	\N
881	8	VILA VELHA	2010-03-11 00:00:00	\N	\N
882	8	VITÓRIA	2010-03-11 00:00:00	\N	\N
883	9	ABADIA DE GOIÁS	2010-03-11 00:00:00	\N	\N
884	9	ABADIÂNIA	2010-03-11 00:00:00	\N	\N
885	9	ACREÚNA	2010-03-11 00:00:00	\N	\N
886	9	ADELÂNDIA	2010-03-11 00:00:00	\N	\N
887	9	ÁGUA FRIA DE GOIÁS	2010-03-11 00:00:00	\N	\N
888	9	ÁGUA LIMPA	2010-03-11 00:00:00	\N	\N
889	9	ÁGUA LINDAS DE GOIÁS	2010-03-11 00:00:00	\N	\N
890	9	ALEXÂNIA	2010-03-11 00:00:00	\N	\N
891	9	ALOÂNDIA	2010-03-11 00:00:00	\N	\N
892	9	ALTO HORIZONTE	2010-03-11 00:00:00	\N	\N
893	9	ALTO PARAÍSO DE GOIÁS	2010-03-11 00:00:00	\N	\N
894	9	ALVORADA DO NORTE	2010-03-11 00:00:00	\N	\N
895	9	AMARALINA	2010-03-11 00:00:00	\N	\N
896	9	AMERICANO DO BRASIL	2010-03-11 00:00:00	\N	\N
897	9	AMORINÓPOLIS	2010-03-11 00:00:00	\N	\N
898	9	ANÁPOLIS	2010-03-11 00:00:00	\N	\N
899	9	ANHANGUERA	2010-03-11 00:00:00	\N	\N
900	9	ANICUNS	2010-03-11 00:00:00	\N	\N
901	9	APARECIDA DE GOIÂNIA	2010-03-11 00:00:00	\N	\N
902	9	APARECIDA DO RIO DOCE	2010-03-11 00:00:00	\N	\N
903	9	APORÉ	2010-03-11 00:00:00	\N	\N
904	9	ARAÇU	2010-03-11 00:00:00	\N	\N
905	9	ARAGARÇAS	2010-03-11 00:00:00	\N	\N
906	9	ARAGOIÂNIA	2010-03-11 00:00:00	\N	\N
907	9	ARAGUAPAZ	2010-03-11 00:00:00	\N	\N
908	9	ARENÓPOLIS	2010-03-11 00:00:00	\N	\N
909	9	ARUANÃ	2010-03-11 00:00:00	\N	\N
910	9	AURILÂNDIA	2010-03-11 00:00:00	\N	\N
911	9	AVELINÓPOLIS	2010-03-11 00:00:00	\N	\N
912	9	BALIZA	2010-03-11 00:00:00	\N	\N
913	9	BARRO ALTO	2010-03-11 00:00:00	\N	\N
914	9	BELA VISTA DE GOIÁS	2010-03-11 00:00:00	\N	\N
915	9	BOM JARDIM DE GOIÁS	2010-03-11 00:00:00	\N	\N
916	9	BOM JESUS DE GOIÁS	2010-03-11 00:00:00	\N	\N
917	9	BONFINÓPOLIS	2010-03-11 00:00:00	\N	\N
918	9	BONÓPOLIS	2010-03-11 00:00:00	\N	\N
919	9	BRAZABRANTES	2010-03-11 00:00:00	\N	\N
920	9	BRITÂNIA	2010-03-11 00:00:00	\N	\N
921	9	BURITI ALEGRE	2010-03-11 00:00:00	\N	\N
922	9	BURITI DE GOIÁS	2010-03-11 00:00:00	\N	\N
923	9	BURITINÓPOLIS	2010-03-11 00:00:00	\N	\N
924	9	CABECEIRAS	2010-03-11 00:00:00	\N	\N
925	9	CACHOEIRA ALTA	2010-03-11 00:00:00	\N	\N
926	9	CACHOEIRA DE GOIÁS	2010-03-11 00:00:00	\N	\N
927	9	CACHOEIRA DOURADA	2010-03-11 00:00:00	\N	\N
928	9	CAÇU	2010-03-11 00:00:00	\N	\N
929	9	CAIAPÔNIA	2010-03-11 00:00:00	\N	\N
930	9	CALDAS NOVAS	2010-03-11 00:00:00	\N	\N
931	9	CALDAZINHA	2010-03-11 00:00:00	\N	\N
932	9	CAMPESTRE DE GOIÁS	2010-03-11 00:00:00	\N	\N
933	9	CAMPINAÇU	2010-03-11 00:00:00	\N	\N
934	9	CAMPINORTE	2010-03-11 00:00:00	\N	\N
935	9	CAMPO ALEGRE DE GOIÁS	2010-03-11 00:00:00	\N	\N
936	9	CAMPO LIMPO DE GOIÁS	2010-03-11 00:00:00	\N	\N
937	9	CAMPOS BELOS	2010-03-11 00:00:00	\N	\N
938	9	CAMPOS VERDES	2010-03-11 00:00:00	\N	\N
939	9	CARMO DO RIO VERDE	2010-03-11 00:00:00	\N	\N
940	9	CASTELÂNDIA	2010-03-11 00:00:00	\N	\N
941	9	CATALÃO	2010-03-11 00:00:00	\N	\N
942	9	CATURAÍ	2010-03-11 00:00:00	\N	\N
943	9	CAVALCANTE	2010-03-11 00:00:00	\N	\N
944	9	CERES	2010-03-11 00:00:00	\N	\N
945	9	CEZARINA	2010-03-11 00:00:00	\N	\N
946	9	CHAPADÃO DO CÉU	2010-03-11 00:00:00	\N	\N
947	9	CIDADE OCIDENTAL	2010-03-11 00:00:00	\N	\N
948	9	COCALZINHO DE GOIÁS	2010-03-11 00:00:00	\N	\N
949	9	COLINAS DO SUL	2010-03-11 00:00:00	\N	\N
950	9	CÓRREGO DO OURO	2010-03-11 00:00:00	\N	\N
951	9	CORUMBÁ DE GOIÁS	2010-03-11 00:00:00	\N	\N
952	9	CORUMBAÍBA	2010-03-11 00:00:00	\N	\N
953	9	CRISTALINA	2010-03-11 00:00:00	\N	\N
954	9	CRISTIANÓPOLIS	2010-03-11 00:00:00	\N	\N
955	9	CRIXAS	2010-03-11 00:00:00	\N	\N
956	9	CROMÍNIA	2010-03-11 00:00:00	\N	\N
957	9	CUMARI	2010-03-11 00:00:00	\N	\N
958	9	DAMIANÓPOLIS	2010-03-11 00:00:00	\N	\N
959	9	DAMOLÂNDIA	2010-03-11 00:00:00	\N	\N
960	9	DAVINÓPOLIS	2010-03-11 00:00:00	\N	\N
961	9	DIORAMA	2010-03-11 00:00:00	\N	\N
962	9	DIVINÓPOLIS DE GOIÁS	2010-03-11 00:00:00	\N	\N
963	9	DOVERLÂNDIA	2010-03-11 00:00:00	\N	\N
964	9	EDEALINA	2010-03-11 00:00:00	\N	\N
965	9	EDEIA	2010-03-11 00:00:00	\N	\N
966	9	ESTRELA DO NORTE	2010-03-11 00:00:00	\N	\N
967	9	FAINA	2010-03-11 00:00:00	\N	\N
968	9	FAZENDA NOVA	2010-03-11 00:00:00	\N	\N
969	9	FIRMINÓPOLIS	2010-03-11 00:00:00	\N	\N
970	9	FLORES DE GOIÁS	2010-03-11 00:00:00	\N	\N
971	9	FORMOSA	2010-03-11 00:00:00	\N	\N
972	9	FORMOSO	2010-03-11 00:00:00	\N	\N
973	9	GAMELEIRA DE GOIÁS	2010-03-11 00:00:00	\N	\N
974	9	GOIANÁPOLIS	2010-03-11 00:00:00	\N	\N
975	9	GOIANDIRA	2010-03-11 00:00:00	\N	\N
976	9	GOIANÉSIA	2010-03-11 00:00:00	\N	\N
977	9	GOIÂNIA	2010-03-11 00:00:00	\N	\N
978	9	GOIANIRA	2010-03-11 00:00:00	\N	\N
979	9	GOIÁS	2010-03-11 00:00:00	\N	\N
980	9	GOIATUBA	2010-03-11 00:00:00	\N	\N
981	9	GOUVELÂNDIA	2010-03-11 00:00:00	\N	\N
982	9	GUAPO	2010-03-11 00:00:00	\N	\N
983	9	GUARAÍTA	2010-03-11 00:00:00	\N	\N
984	9	GUARANI DE GOÍAS	2010-03-11 00:00:00	\N	\N
985	9	GUARINOS	2010-03-11 00:00:00	\N	\N
986	9	HEITORAÍ	2010-03-11 00:00:00	\N	\N
987	9	HIDROLÂNDIA	2010-03-11 00:00:00	\N	\N
988	9	HIDROLINA	2010-03-11 00:00:00	\N	\N
989	9	IACIARA	2010-03-11 00:00:00	\N	\N
990	9	INACIOLÂNDIA	2010-03-11 00:00:00	\N	\N
991	9	INDIARA	2010-03-11 00:00:00	\N	\N
992	9	INHUMAS	2010-03-11 00:00:00	\N	\N
993	9	IPAMERI	2010-03-11 00:00:00	\N	\N
994	9	IPIRANGA DE GOIÁS	2010-03-11 00:00:00	\N	\N
995	9	IPORÃ	2010-03-11 00:00:00	\N	\N
996	9	ISRAELÂNDIA	2010-03-11 00:00:00	\N	\N
997	9	ITABERAÍ	2010-03-11 00:00:00	\N	\N
998	9	ITAGUARI	2010-03-11 00:00:00	\N	\N
999	9	ITAGUARU	2010-03-11 00:00:00	\N	\N
1000	9	ITAJÁ	2010-03-11 00:00:00	\N	\N
1001	9	ITAPACI	2010-03-11 00:00:00	\N	\N
1002	9	ITAPIRAPUÃ	2010-03-11 00:00:00	\N	\N
1003	9	ITAPURANGA	2010-03-11 00:00:00	\N	\N
1004	9	ITARUMÃ	2010-03-11 00:00:00	\N	\N
1005	9	ITAUÇU	2010-03-11 00:00:00	\N	\N
1006	9	ITUMBIARA	2010-03-11 00:00:00	\N	\N
1007	9	IVOLÂNDIA	2010-03-11 00:00:00	\N	\N
1008	9	JANDAIA	2010-03-11 00:00:00	\N	\N
1009	9	JARAGUÁ	2010-03-11 00:00:00	\N	\N
1010	9	JATAÍ	2010-03-11 00:00:00	\N	\N
1011	9	JAUPACI	2010-03-11 00:00:00	\N	\N
1012	9	JESÚPOLIS	2010-03-11 00:00:00	\N	\N
1013	9	JOVIÂNIA	2010-03-11 00:00:00	\N	\N
1014	9	JUSSARA	2010-03-11 00:00:00	\N	\N
1015	9	LAGOA SANTA	2010-03-11 00:00:00	\N	\N
1016	9	LEOPOLDO DE BULHÕES	2010-03-11 00:00:00	\N	\N
1017	9	LUZIÂNIA	2010-03-11 00:00:00	\N	\N
1018	9	MAIRIPOTABA	2010-03-11 00:00:00	\N	\N
1019	9	MAMBAÍ	2010-03-11 00:00:00	\N	\N
1020	9	MARA ROSA	2010-03-11 00:00:00	\N	\N
1021	9	MARZAGÃO	2010-03-11 00:00:00	\N	\N
1022	9	MATRINCHÃ	2010-03-11 00:00:00	\N	\N
1023	9	MAURILÂNDIA	2010-03-11 00:00:00	\N	\N
1024	9	MIMOSO DE GOIÁS	2010-03-11 00:00:00	\N	\N
1025	9	MINAÇU	2010-03-11 00:00:00	\N	\N
1026	9	MINEIROS	2010-03-11 00:00:00	\N	\N
1027	9	MOIPORÃ	2010-03-11 00:00:00	\N	\N
1028	9	MONTE ALEGRE DE GOIÁS	2010-03-11 00:00:00	\N	\N
1029	9	MONTES CLAROS DE GOIÁS	2010-03-11 00:00:00	\N	\N
1030	9	MONTIVIDIU	2010-03-11 00:00:00	\N	\N
1031	9	MONTIVIDIU DO NORTE	2010-03-11 00:00:00	\N	\N
1032	9	MORRINHOS	2010-03-11 00:00:00	\N	\N
1033	9	MORRO AGUDO DE GOIÁS	2010-03-11 00:00:00	\N	\N
1034	9	MOSSAMEDES	2010-03-11 00:00:00	\N	\N
1035	9	MOZARLÂNDIA	2010-03-11 00:00:00	\N	\N
1036	9	MUNDO NOVO	2010-03-11 00:00:00	\N	\N
1037	9	MUTUNÓPOLIS	2010-03-11 00:00:00	\N	\N
1038	9	NAZÁRIO	2010-03-11 00:00:00	\N	\N
1039	9	NERÓPOLIS	2010-03-11 00:00:00	\N	\N
1040	9	NIQUELÂNDIA	2010-03-11 00:00:00	\N	\N
1041	9	NOVA AMÉRICA	2010-03-11 00:00:00	\N	\N
1042	9	NOVA AURORA	2010-03-11 00:00:00	\N	\N
1043	9	NOVA CRIXAS	2010-03-11 00:00:00	\N	\N
1044	9	NOVA GLÓRIA	2010-03-11 00:00:00	\N	\N
1045	9	NOVA IGUAÇU DE GOIÁS	2010-03-11 00:00:00	\N	\N
1046	9	NOVA ROMA	2010-03-11 00:00:00	\N	\N
1047	9	NOVA VENEZA	2010-03-11 00:00:00	\N	\N
1048	9	NOVO BRASIL	2010-03-11 00:00:00	\N	\N
1049	9	NOVO GAMA	2010-03-11 00:00:00	\N	\N
1050	9	NOVO PLANALTO	2010-03-11 00:00:00	\N	\N
1051	9	ORIZONA	2010-03-11 00:00:00	\N	\N
1052	9	OURO VERDE DE GOIÁS	2010-03-11 00:00:00	\N	\N
1053	9	OUVIDOR	2010-03-11 00:00:00	\N	\N
1054	9	PADRE BERNARDO	2010-03-11 00:00:00	\N	\N
1055	9	PALESTINA DE GOIÁS	2010-03-11 00:00:00	\N	\N
1056	9	PALMEIRA DE GOIÁS	2010-03-11 00:00:00	\N	\N
1057	9	PALMELO	2010-03-11 00:00:00	\N	\N
1058	9	PALMINÓPOLIS	2010-03-11 00:00:00	\N	\N
1059	9	PANAMÁ	2010-03-11 00:00:00	\N	\N
1060	9	PARANAIGUARA	2010-03-11 00:00:00	\N	\N
1061	9	PARAÚNA	2010-03-11 00:00:00	\N	\N
1062	9	PEROLÂNDIA	2010-03-11 00:00:00	\N	\N
1063	9	PETROLINA DE GOIÁS	2010-03-11 00:00:00	\N	\N
1064	9	PILAR DE GOIÁS	2010-03-11 00:00:00	\N	\N
1065	9	PIRACANJUBA	2010-03-11 00:00:00	\N	\N
1066	9	PIRANHAS	2010-03-11 00:00:00	\N	\N
1067	9	PIRENÓPOLIS	2010-03-11 00:00:00	\N	\N
1068	9	PIRES DO RIO	2010-03-11 00:00:00	\N	\N
1069	9	PLANALTINA	2010-03-11 00:00:00	\N	\N
1070	9	PONTALINA	2010-03-11 00:00:00	\N	\N
1071	9	PORANGATU	2010-03-11 00:00:00	\N	\N
1072	9	PORTEIRÃO	2010-03-11 00:00:00	\N	\N
1073	9	PORTELÂNDIA	2010-03-11 00:00:00	\N	\N
1074	9	POSSE	2010-03-11 00:00:00	\N	\N
1075	9	PROFESSOR JAMIL	2010-03-11 00:00:00	\N	\N
1076	9	QUIRINÓPOLIS	2010-03-11 00:00:00	\N	\N
1077	9	RIALMA	2010-03-11 00:00:00	\N	\N
1078	9	RIANÁPOLIS	2010-03-11 00:00:00	\N	\N
1079	9	RIO QUENTE	2010-03-11 00:00:00	\N	\N
1080	9	RIO VERDE	2010-03-11 00:00:00	\N	\N
1081	9	RUBIATABA	2010-03-11 00:00:00	\N	\N
1082	9	SANCLERLÂNDIA	2010-03-11 00:00:00	\N	\N
1083	9	SANTA BÁRBARA DE GOIÁS	2010-03-11 00:00:00	\N	\N
1084	9	SANTA CRUZ DE GOIÁS	2010-03-11 00:00:00	\N	\N
1085	9	SANTA FÉ DE GOIÁS	2010-03-11 00:00:00	\N	\N
1086	9	SANTA HELENA DE GOIÁS	2010-03-11 00:00:00	\N	\N
1087	9	SANTA ISABEL	2010-03-11 00:00:00	\N	\N
1088	9	SANTA RITA DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
1089	9	SANTA RITA DO NOVO DESTINO	2010-03-11 00:00:00	\N	\N
1090	9	SANTA ROSA DE GOIÁS	2010-03-11 00:00:00	\N	\N
1091	9	SANTA TEREZA DE GOIÁS	2010-03-11 00:00:00	\N	\N
1092	9	SANTA TEREZINHA DE GOIÁS	2010-03-11 00:00:00	\N	\N
1093	9	SANTO ANTÔNIO DA BARRA	2010-03-11 00:00:00	\N	\N
1094	9	SANTO ANTÔNIO DE GOIÁS	2010-03-11 00:00:00	\N	\N
1095	9	SANTO ANTÔNIO DO DESCOBERTO	2010-03-11 00:00:00	\N	\N
1096	9	SÃO DOMINGOS	2010-03-11 00:00:00	\N	\N
1097	9	SÃO FRANCISCO DE GOIÁS	2010-03-11 00:00:00	\N	\N
1098	9	SÃO JOÃO D ALIANÇA	2010-03-11 00:00:00	\N	\N
1099	9	SÃO JOÃO DA PARAÚNA	2010-03-11 00:00:00	\N	\N
1100	9	SÃO LUÍS DE MONTES BELOS	2010-03-11 00:00:00	\N	\N
1101	9	SÃO LUIZ DO NORTE	2010-03-11 00:00:00	\N	\N
1102	9	SÃO MIGUEL DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
1103	9	SÃO MIGUEL DO PASSA QUATRO	2010-03-11 00:00:00	\N	\N
1104	9	SÃO PATRÍCIO	2010-03-11 00:00:00	\N	\N
1105	9	SÃO SIMÃO	2010-03-11 00:00:00	\N	\N
1106	9	SENADOR CANEDO	2010-03-11 00:00:00	\N	\N
1107	9	SERRANÓPOLIS	2010-03-11 00:00:00	\N	\N
1108	9	SILVÂNIA	2010-03-11 00:00:00	\N	\N
1109	9	SIMOLÂNDIA	2010-03-11 00:00:00	\N	\N
1110	9	SÍTIO D ABADIA	2010-03-11 00:00:00	\N	\N
1111	9	TAQUARAL DE GOIÁS	2010-03-11 00:00:00	\N	\N
1112	9	TERESINA DE GOIÁS	2010-03-11 00:00:00	\N	\N
1113	9	TEREZÓPOLIS DE GOIÁS	2010-03-11 00:00:00	\N	\N
1114	9	TRÊS RANCHOS	2010-03-11 00:00:00	\N	\N
1115	9	TRINDADE	2010-03-11 00:00:00	\N	\N
1116	9	TROMBAS	2010-03-11 00:00:00	\N	\N
1117	9	TURVÂNIA	2010-03-11 00:00:00	\N	\N
1118	9	TURVELÂNDIA	2010-03-11 00:00:00	\N	\N
1119	9	UIRAPURU	2010-03-11 00:00:00	\N	\N
1120	9	URUAÇU	2010-03-11 00:00:00	\N	\N
1121	9	URUANA	2010-03-11 00:00:00	\N	\N
1122	9	URUTAÍ	2010-03-11 00:00:00	\N	\N
1123	9	VALPARAÍSO DE GOIÁS	2010-03-11 00:00:00	\N	\N
1124	9	VARJÃO	2010-03-11 00:00:00	\N	\N
1125	9	VIANÓPOLIS	2010-03-11 00:00:00	\N	\N
1126	9	VICENTINÓPOLIS	2010-03-11 00:00:00	\N	\N
1127	9	VILA BOA	2010-03-11 00:00:00	\N	\N
1128	9	VILA PROPÍCIO	2010-03-11 00:00:00	\N	\N
1129	10	AÇAILÂNDIA	2010-03-11 00:00:00	\N	\N
1130	10	AFONSO CUNHA	2010-03-11 00:00:00	\N	\N
1131	10	ÁGUA DOCE DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1132	10	ALCÂNTARA	2010-03-11 00:00:00	\N	\N
1133	10	ALDEIAS ALTAS	2010-03-11 00:00:00	\N	\N
1134	10	ALTAMIRA DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1135	10	ALTO ALEGRE DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1136	10	ALTO ALEGRE DO PINDARÉ	2010-03-11 00:00:00	\N	\N
1137	10	ALTO PARNAÍBA	2010-03-11 00:00:00	\N	\N
1138	10	AMAPÁ DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1139	10	AMARANTE DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1140	10	ANAJATUBA	2010-03-11 00:00:00	\N	\N
1141	10	ANAPURUS	2010-03-11 00:00:00	\N	\N
1142	10	APICUM-AÇU	2010-03-11 00:00:00	\N	\N
1143	10	ARAGUANÃ	2010-03-11 00:00:00	\N	\N
1144	10	ARAIÓSES	2010-03-11 00:00:00	\N	\N
1145	10	ARAME	2010-03-11 00:00:00	\N	\N
1146	10	ARARI	2010-03-11 00:00:00	\N	\N
1147	10	AXIXÁ	2010-03-11 00:00:00	\N	\N
1148	10	BACABAL	2010-03-11 00:00:00	\N	\N
1149	10	BACABEIRA	2010-03-11 00:00:00	\N	\N
1150	10	BACURI	2010-03-11 00:00:00	\N	\N
1151	10	BACURITUBA	2010-03-11 00:00:00	\N	\N
1152	10	BALSAS	2010-03-11 00:00:00	\N	\N
1153	10	BARÃO DE GRAJAÚ	2010-03-11 00:00:00	\N	\N
1154	10	BARRA DO CORDA	2010-03-11 00:00:00	\N	\N
1155	10	BARREIRINHAS	2010-03-11 00:00:00	\N	\N
1156	10	BELA VISTA DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1157	10	BELÁGUA	2010-03-11 00:00:00	\N	\N
1158	10	BENEDITO LEITE	2010-03-11 00:00:00	\N	\N
1159	10	BEQUIMÃO	2010-03-11 00:00:00	\N	\N
1160	10	BERNARDO DO MEARIM	2010-03-11 00:00:00	\N	\N
1161	10	BOA VISTA DO GURUPI	2010-03-11 00:00:00	\N	\N
1162	10	BOM JARDIM	2010-03-11 00:00:00	\N	\N
1163	10	BOM JESUS DAS SELVAS	2010-03-11 00:00:00	\N	\N
1164	10	BOM LUGAR	2010-03-11 00:00:00	\N	\N
1165	10	BREJO	2010-03-11 00:00:00	\N	\N
1166	10	BREJO DE AREIA	2010-03-11 00:00:00	\N	\N
1167	10	BURITI	2010-03-11 00:00:00	\N	\N
1168	10	BURITI BRAVO	2010-03-11 00:00:00	\N	\N
1169	10	BURITICUPU	2010-03-11 00:00:00	\N	\N
1170	10	BURITIRANA	2010-03-11 00:00:00	\N	\N
1171	10	CACHOEIRA GRANDE	2010-03-11 00:00:00	\N	\N
1172	10	CAJAPIO	2010-03-11 00:00:00	\N	\N
1173	10	CAJARI	2010-03-11 00:00:00	\N	\N
1174	10	CAMPESTRE DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1175	10	CÂNDIDO MENDES	2010-03-11 00:00:00	\N	\N
1176	10	CANTANHEDE	2010-03-11 00:00:00	\N	\N
1177	10	CAPINZAL DO NORTE	2010-03-11 00:00:00	\N	\N
1178	10	CAROLINA	2010-03-11 00:00:00	\N	\N
1179	10	CARUTAPERA	2010-03-11 00:00:00	\N	\N
1180	10	CAXIAS	2010-03-11 00:00:00	\N	\N
1181	10	CEDRAL	2010-03-11 00:00:00	\N	\N
1182	10	CENTRAL DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1183	10	CENTRO DO GUILHERME	2010-03-11 00:00:00	\N	\N
1184	10	CENTRO NOVO DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1185	10	CHAPADINHA	2010-03-11 00:00:00	\N	\N
1186	10	CIDELÂNDIA	2010-03-11 00:00:00	\N	\N
1187	10	CODÓ	2010-03-11 00:00:00	\N	\N
1188	10	COELHO NETO	2010-03-11 00:00:00	\N	\N
1189	10	COLINAS	2010-03-11 00:00:00	\N	\N
1190	10	CONCEIÇÃO DO LAGO AÇU	2010-03-11 00:00:00	\N	\N
1191	10	COROATÁ	2010-03-11 00:00:00	\N	\N
1192	10	CURURUPU	2010-03-11 00:00:00	\N	\N
1193	10	DAVINÓPOLIS	2010-03-11 00:00:00	\N	\N
1194	10	DOM PEDRO	2010-03-11 00:00:00	\N	\N
1195	10	DUQUE BACELAR	2010-03-11 00:00:00	\N	\N
1196	10	ESPERANTINÓPOLIS	2010-03-11 00:00:00	\N	\N
1197	10	ESTREITO	2010-03-11 00:00:00	\N	\N
1198	10	FEIRA NOVA DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1199	10	FERNANDO FALCÃO	2010-03-11 00:00:00	\N	\N
1200	10	FORMOSA DA SERRA NEGRA	2010-03-11 00:00:00	\N	\N
1201	10	FORTALEZA DOS NOGUEIRAS	2010-03-11 00:00:00	\N	\N
1202	10	FORTUNA	2010-03-11 00:00:00	\N	\N
1203	10	GODOFREDO VIANA	2010-03-11 00:00:00	\N	\N
1204	10	GONÇALVES DIAS	2010-03-11 00:00:00	\N	\N
1205	10	GOVERNADOR ARCHER	2010-03-11 00:00:00	\N	\N
1206	10	GOVERNADOR EDISON LOBÃO	2010-03-11 00:00:00	\N	\N
1207	10	GOVERNADOR EUGÊNIO BARROS	2010-03-11 00:00:00	\N	\N
1208	10	GOVERNADOR LUÍS ROCHA	2010-03-11 00:00:00	\N	\N
1209	10	GOVERNADOR NEWTON BELLO	2010-03-11 00:00:00	\N	\N
1210	10	GOVERNADOR NUNES FREIRE	2010-03-11 00:00:00	\N	\N
1211	10	GRAÇA ARANHA	2010-03-11 00:00:00	\N	\N
1212	10	GRAJAÚ	2010-03-11 00:00:00	\N	\N
1213	10	GUIMARÃES	2010-03-11 00:00:00	\N	\N
1214	10	HUMBERTO DE CAMPOS	2010-03-11 00:00:00	\N	\N
1215	10	ICATU	2010-03-11 00:00:00	\N	\N
1216	10	IGARAPÉ DO MEIO	2010-03-11 00:00:00	\N	\N
1217	10	IGARAPÉ GRANDE	2010-03-11 00:00:00	\N	\N
1218	10	IMPERATRIZ	2010-03-11 00:00:00	\N	\N
1219	10	ITAIPAVA DO GRAJAÚ	2010-03-11 00:00:00	\N	\N
1220	10	ITAPECURU MIRIM	2010-03-11 00:00:00	\N	\N
1221	10	ITINGA DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1222	10	JATOBÁ	2010-03-11 00:00:00	\N	\N
1223	10	JENIPAPO DOS VIEIRAS	2010-03-11 00:00:00	\N	\N
1224	10	JOÃO LISBOA	2010-03-11 00:00:00	\N	\N
1225	10	JOSELÂNDIA	2010-03-11 00:00:00	\N	\N
1226	10	JUNCO DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1227	10	LAGO DA PEDRA	2010-03-11 00:00:00	\N	\N
1228	10	LAGO DO JUNCO	2010-03-11 00:00:00	\N	\N
1229	10	LAGO DOS RODRIGUES	2010-03-11 00:00:00	\N	\N
1230	10	LAGO VERDE	2010-03-11 00:00:00	\N	\N
1231	10	LAGOA DO MATO	2010-03-11 00:00:00	\N	\N
1232	10	LAGOA GRANDE DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1233	10	LAJEADO NOVO	2010-03-11 00:00:00	\N	\N
1234	10	LIMA CAMPOS	2010-03-11 00:00:00	\N	\N
1235	10	LORETO	2010-03-11 00:00:00	\N	\N
1236	10	LUÍS DOMINGUES	2010-03-11 00:00:00	\N	\N
1237	10	MAGALHÃES DE ALMEIDA	2010-03-11 00:00:00	\N	\N
1238	10	MARACAÇUMÉ	2010-03-11 00:00:00	\N	\N
1239	10	MARAJÁ DO SENA	2010-03-11 00:00:00	\N	\N
1240	10	MARANHÃOZINHO	2010-03-11 00:00:00	\N	\N
1241	10	MATA ROMA	2010-03-11 00:00:00	\N	\N
1242	10	MATINHA	2010-03-11 00:00:00	\N	\N
1243	10	MATÕES	2010-03-11 00:00:00	\N	\N
1244	10	MATÕES DO NORTE	2010-03-11 00:00:00	\N	\N
1245	10	MILAGRES DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1246	10	MIRADOR	2010-03-11 00:00:00	\N	\N
1247	10	MIRANDA DO NORTE	2010-03-11 00:00:00	\N	\N
1248	10	MIRINZAL	2010-03-11 00:00:00	\N	\N
1249	10	MONÇÃO	2010-03-11 00:00:00	\N	\N
1250	10	MONTES ALTOS	2010-03-11 00:00:00	\N	\N
1251	10	MORROS	2010-03-11 00:00:00	\N	\N
1252	10	NINA RODRIGUES	2010-03-11 00:00:00	\N	\N
1253	10	NOVA COLINAS	2010-03-11 00:00:00	\N	\N
1254	10	NOVA IORQUE	2010-03-11 00:00:00	\N	\N
1255	10	NOVA OLINDA DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1256	10	OLHO D ÁGUA DAS CUNHÃS	2010-03-11 00:00:00	\N	\N
1257	10	OLINDA NOVA DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1258	10	PAÇO DO LUMIAR	2010-03-11 00:00:00	\N	\N
1259	10	PALMEIRÂNDIA	2010-03-11 00:00:00	\N	\N
1260	10	PARAIBANO	2010-03-11 00:00:00	\N	\N
1261	10	PARNARAMA	2010-03-11 00:00:00	\N	\N
1262	10	PASSAGEM FRANCA	2010-03-11 00:00:00	\N	\N
1263	10	PASTOS BONS	2010-03-11 00:00:00	\N	\N
1264	10	PAULINO NEVES	2010-03-11 00:00:00	\N	\N
1265	10	PAULO RAMOS	2010-03-11 00:00:00	\N	\N
1266	10	PEDREIRAS	2010-03-11 00:00:00	\N	\N
1267	10	PEDRO DO ROSÁRIO	2010-03-11 00:00:00	\N	\N
1268	10	PENALVA	2010-03-11 00:00:00	\N	\N
1269	10	PERI MIRIM	2010-03-11 00:00:00	\N	\N
1270	10	PERITORÓ	2010-03-11 00:00:00	\N	\N
1271	10	PINDARÉ-MIRIM	2010-03-11 00:00:00	\N	\N
1272	10	PINHEIRO	2010-03-11 00:00:00	\N	\N
1273	10	PIO XII	2010-03-11 00:00:00	\N	\N
1274	10	PIRAPEMAS	2010-03-11 00:00:00	\N	\N
1275	10	POÇÃO DE PEDRAS	2010-03-11 00:00:00	\N	\N
1276	10	PORTO FRANCO	2010-03-11 00:00:00	\N	\N
1277	10	PORTO RICO DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1278	10	PRESIDENTE DUTRA	2010-03-11 00:00:00	\N	\N
1279	10	PRESIDENTE JUSCELINO	2010-03-11 00:00:00	\N	\N
1280	10	PRESIDENTE MÉDICI	2010-03-11 00:00:00	\N	\N
1281	10	PRESIDENTE SARNEY	2010-03-11 00:00:00	\N	\N
1282	10	PRESIDENTE VARGAS	2010-03-11 00:00:00	\N	\N
1283	10	PRIMEIRA CRUZ	2010-03-11 00:00:00	\N	\N
1284	10	RAPOSA	2010-03-11 00:00:00	\N	\N
1285	10	RIACHÃO	2010-03-11 00:00:00	\N	\N
1286	10	RIBAMAR FIQUENE	2010-03-11 00:00:00	\N	\N
1287	10	ROSÁRIO	2010-03-11 00:00:00	\N	\N
1288	10	SAMBAÍBA	2010-03-11 00:00:00	\N	\N
1289	10	SANTA FILOMENA DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1290	10	SANTA HELENA	2010-03-11 00:00:00	\N	\N
1291	10	SANTA INÊS	2010-03-11 00:00:00	\N	\N
1292	10	SANTA LUZIA	2010-03-11 00:00:00	\N	\N
1293	10	SANTA LUZIA DO PARUÁ	2010-03-11 00:00:00	\N	\N
1294	10	SANTA QUITÉRIA DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1295	10	SANTA RITA	2010-03-11 00:00:00	\N	\N
1296	10	SANTANA DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1297	10	SANTO AMARO DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1298	10	SANTO ANTÔNIO DOS LOPES	2010-03-11 00:00:00	\N	\N
1299	10	SÃO BENEDITO DO RIO PRETO	2010-03-11 00:00:00	\N	\N
1300	10	SÃO BENTO	2010-03-11 00:00:00	\N	\N
1301	10	SÃO BERNARDO	2010-03-11 00:00:00	\N	\N
1302	10	SÃO DOMINGOS DO AZEITÃO	2010-03-11 00:00:00	\N	\N
1303	10	SÃO DOMINGOS DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1304	10	SÃO FÉLIX DE BALSAS	2010-03-11 00:00:00	\N	\N
1305	10	SÃO FRANCISCO DO BREJÃO	2010-03-11 00:00:00	\N	\N
1306	10	SÃO FRANCISCO DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1307	10	SÃO JOÃO BATISTA	2010-03-11 00:00:00	\N	\N
1308	10	SÃO JOÃO DO CARU	2010-03-11 00:00:00	\N	\N
1309	10	SÃO JOÃO DO PARAÍSO	2010-03-11 00:00:00	\N	\N
1310	10	SÃO JOÃO DO SÓTER	2010-03-11 00:00:00	\N	\N
1311	10	SÃO JOÃO DOS PATOS	2010-03-11 00:00:00	\N	\N
1312	10	SÃO JOSÉ DE RIBAMAR	2010-03-11 00:00:00	\N	\N
1313	10	SÃO JOSÉ DOS BASÍLIOS	2010-03-11 00:00:00	\N	\N
1314	10	SÃO LUÍS	2010-03-11 00:00:00	\N	\N
1315	10	SÃO LUÍS GONZAGA DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1316	10	SÃO MATEUS DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1317	10	SÃO PEDRO DA ÁGUA BRANCA	2010-03-11 00:00:00	\N	\N
1318	10	SÃO PEDRO DOS CRENTES	2010-03-11 00:00:00	\N	\N
1319	10	SÃO RAIMUNDO DAS MANGABEIRAS	2010-03-11 00:00:00	\N	\N
1320	10	SÃO RAIMUNDO DO DOCA BEZERRA	2010-03-11 00:00:00	\N	\N
1321	10	SÃO ROBERTO	2010-03-11 00:00:00	\N	\N
1322	10	SÃO VICENTE FERRER	2010-03-11 00:00:00	\N	\N
1323	10	SATUBINHA	2010-03-11 00:00:00	\N	\N
1324	10	SENADOR ALEXANDRE COSTA	2010-03-11 00:00:00	\N	\N
1325	10	SENADOR LA ROQUE	2010-03-11 00:00:00	\N	\N
1326	10	SERRANO DO MARANHÃO	2010-03-11 00:00:00	\N	\N
1327	10	SÍTIO NOVO	2010-03-11 00:00:00	\N	\N
1328	10	SUCUPIRA DO NORTE	2010-03-11 00:00:00	\N	\N
1329	10	SUCUPIRA DO RIACHÃO	2010-03-11 00:00:00	\N	\N
1330	10	TASSO FRAGOSO	2010-03-11 00:00:00	\N	\N
1331	10	TIMBIRAS	2010-03-11 00:00:00	\N	\N
1332	10	TIMON	2010-03-11 00:00:00	\N	\N
1333	10	TRIZIDELA DO VALE	2010-03-11 00:00:00	\N	\N
1334	10	TUFILÂNDIA	2010-03-11 00:00:00	\N	\N
1335	10	TUNTUM	2010-03-11 00:00:00	\N	\N
1336	10	TURIAÇU	2010-03-11 00:00:00	\N	\N
1337	10	TURILÂNDIA	2010-03-11 00:00:00	\N	\N
1338	10	TUTÓIA	2010-03-11 00:00:00	\N	\N
1339	10	URBANO SANTOS	2010-03-11 00:00:00	\N	\N
1340	10	VARGEM GRANDE	2010-03-11 00:00:00	\N	\N
1341	10	VIANA	2010-03-11 00:00:00	\N	\N
1342	10	VILA NOVA DOS MARTÍRIOS	2010-03-11 00:00:00	\N	\N
1343	10	VITÓRIA DO MEARIM	2010-03-11 00:00:00	\N	\N
1344	10	VITORINO FREIRE	2010-03-11 00:00:00	\N	\N
1345	10	ZÉ DOCA	2010-03-11 00:00:00	\N	\N
1347	11	ABAETÉ	2010-03-11 00:00:00	\N	\N
1348	11	ABRE CAMPO	2010-03-11 00:00:00	\N	\N
1349	11	ACAIACA	2010-03-11 00:00:00	\N	\N
1350	11	AÇUCENA	2010-03-11 00:00:00	\N	\N
1351	11	ÁGUA BOA	2010-03-11 00:00:00	\N	\N
1352	11	ÁGUA COMPRIDA	2010-03-11 00:00:00	\N	\N
1353	11	AGUANIL	2010-03-11 00:00:00	\N	\N
1354	11	ÁGUAS FORMOSAS	2010-03-11 00:00:00	\N	\N
1355	11	ÁGUAS VERMELHAS	2010-03-11 00:00:00	\N	\N
1356	11	AIMORÉS	2010-03-11 00:00:00	\N	\N
1357	11	AIURUOCA	2010-03-11 00:00:00	\N	\N
1358	11	ALAGOA	2010-03-11 00:00:00	\N	\N
1359	11	ALBERTINA	2010-03-11 00:00:00	\N	\N
1360	11	ALÉM PARAÍBA	2010-03-11 00:00:00	\N	\N
1361	11	ALFENAS	2010-03-11 00:00:00	\N	\N
1362	11	ALFREDO VASCONCELOS	2010-03-11 00:00:00	\N	\N
1363	11	ALMENARA	2010-03-11 00:00:00	\N	\N
1364	11	ALPERCATA	2010-03-11 00:00:00	\N	\N
1365	11	ALPINÓPOLIS	2010-03-11 00:00:00	\N	\N
1366	11	ALTEROSA	2010-03-11 00:00:00	\N	\N
1367	11	ALTO CAPARAÓ	2010-03-11 00:00:00	\N	\N
1368	11	ALTO JEQUITIBÁ	2010-03-11 00:00:00	\N	\N
1369	11	ALTO RIO DOCE	2010-03-11 00:00:00	\N	\N
1370	11	ALVARENGA	2010-03-11 00:00:00	\N	\N
1371	11	ALVINÓPOLIS	2010-03-11 00:00:00	\N	\N
1372	11	ALVORADA DE MINAS	2010-03-11 00:00:00	\N	\N
1373	11	AMPARO DA SERRA	2010-03-11 00:00:00	\N	\N
1374	11	ANDRADAS	2010-03-11 00:00:00	\N	\N
1375	11	ANDRELÂNDIA	2010-03-11 00:00:00	\N	\N
1376	11	ANGELÂNDIA	2010-03-11 00:00:00	\N	\N
1377	11	ANTÔNIO CARLOS	2010-03-11 00:00:00	\N	\N
1378	11	ANTÔNIO DIAS	2010-03-11 00:00:00	\N	\N
1379	11	ANTÔNIO PRADO DE MINAS	2010-03-11 00:00:00	\N	\N
1380	11	ARAÇAÍ	2010-03-11 00:00:00	\N	\N
1381	11	ARACITABA	2010-03-11 00:00:00	\N	\N
1382	11	ARAÇUAÍ	2010-03-11 00:00:00	\N	\N
1383	11	ARAGUARI	2010-03-11 00:00:00	\N	\N
1384	11	ARANTINA	2010-03-11 00:00:00	\N	\N
1385	11	ARAPONGA	2010-03-11 00:00:00	\N	\N
1386	11	ARAPORÃ	2010-03-11 00:00:00	\N	\N
1387	11	ARAPUA	2010-03-11 00:00:00	\N	\N
1388	11	ARAÚJOS	2010-03-11 00:00:00	\N	\N
1389	11	ARAXÁ	2010-03-11 00:00:00	\N	\N
1390	11	ARCEBURGO	2010-03-11 00:00:00	\N	\N
1391	11	ARCOS	2010-03-11 00:00:00	\N	\N
1392	11	AREADO	2010-03-11 00:00:00	\N	\N
1393	11	ARGIRITA	2010-03-11 00:00:00	\N	\N
1394	11	ARICANDUVA	2010-03-11 00:00:00	\N	\N
1395	11	ARINOS	2010-03-11 00:00:00	\N	\N
1396	11	ASTOLFO DUTRA	2010-03-11 00:00:00	\N	\N
1397	11	ATALÉIA	2010-03-11 00:00:00	\N	\N
1398	11	AUGUSTO DE LIMA	2010-03-11 00:00:00	\N	\N
1399	11	BAEPENDI	2010-03-11 00:00:00	\N	\N
1400	11	BALDIM	2010-03-11 00:00:00	\N	\N
1401	11	BAMBUÍ	2010-03-11 00:00:00	\N	\N
1402	11	BANDEIRA	2010-03-11 00:00:00	\N	\N
1403	11	BANDEIRA DO SUL	2010-03-11 00:00:00	\N	\N
1404	11	BARÃO DE COCAIS	2010-03-11 00:00:00	\N	\N
1405	11	BARÃO DE MONTE ALTO	2010-03-11 00:00:00	\N	\N
1406	11	BARBACENA	2010-03-11 00:00:00	\N	\N
1407	11	BARRA LONGA	2010-03-11 00:00:00	\N	\N
1408	11	BARROSO	2010-03-11 00:00:00	\N	\N
1409	11	BELA VISTA DE MINAS	2010-03-11 00:00:00	\N	\N
1410	11	BELMIRO BRAGA	2010-03-11 00:00:00	\N	\N
1411	11	BELO HORIZONTE	2010-03-11 00:00:00	\N	\N
1412	11	BELO ORIENTE	2010-03-11 00:00:00	\N	\N
1413	11	BELO VALE	2010-03-11 00:00:00	\N	\N
1414	11	BERILO	2010-03-11 00:00:00	\N	\N
1415	11	BERIZAL	2010-03-11 00:00:00	\N	\N
1416	11	BERTÓPOLIS	2010-03-11 00:00:00	\N	\N
1417	11	BETIM	2010-03-11 00:00:00	\N	\N
1418	11	BIAS FORTES	2010-03-11 00:00:00	\N	\N
1419	11	BICAS	2010-03-11 00:00:00	\N	\N
1420	11	BIQUINHAS	2010-03-11 00:00:00	\N	\N
1421	11	BOA ESPERANÇA	2010-03-11 00:00:00	\N	\N
1422	11	BOCAINA DE MINAS	2010-03-11 00:00:00	\N	\N
1423	11	BOCAIÚVA	2010-03-11 00:00:00	\N	\N
1424	11	BOM DESPACHO	2010-03-11 00:00:00	\N	\N
1425	11	BOM JARDIM DE MINAS	2010-03-11 00:00:00	\N	\N
1426	11	BOM JESUS DA PENHA	2010-03-11 00:00:00	\N	\N
1427	11	BOM JESUS DO AMPARO	2010-03-11 00:00:00	\N	\N
1428	11	BOM JESUS DO GALHO	2010-03-11 00:00:00	\N	\N
1429	11	BOM REPOUSO	2010-03-11 00:00:00	\N	\N
1430	11	BOM SUCESSO	2010-03-11 00:00:00	\N	\N
1431	11	BONFIM	2010-03-11 00:00:00	\N	\N
1432	11	BONFINÓPOLIS DE MINAS	2010-03-11 00:00:00	\N	\N
1433	11	BONITO DE MINAS	2010-03-11 00:00:00	\N	\N
1434	11	BORDA DA MATA	2010-03-11 00:00:00	\N	\N
1435	11	BOTELHOS	2010-03-11 00:00:00	\N	\N
1436	11	BOTUMIRIM	2010-03-11 00:00:00	\N	\N
1437	11	BRÁS PIRES	2010-03-11 00:00:00	\N	\N
1438	11	BRASILÂNDIA DE MINAS	2010-03-11 00:00:00	\N	\N
1439	11	BRASÍLIA DE MINAS	2010-03-11 00:00:00	\N	\N
1440	11	BRASÓPOLIS	2010-03-11 00:00:00	\N	\N
1441	11	BRAÚNAS	2010-03-11 00:00:00	\N	\N
1442	11	BRUMADINHO	2010-03-11 00:00:00	\N	\N
1443	11	BUENO BRANDÃO	2010-03-11 00:00:00	\N	\N
1444	11	BUENÓPOLIS	2010-03-11 00:00:00	\N	\N
1445	11	BUGRE	2010-03-11 00:00:00	\N	\N
1446	11	BURITIS	2010-03-11 00:00:00	\N	\N
1447	11	BURITIZEIRO	2010-03-11 00:00:00	\N	\N
1448	11	CABECEIRA GRANDE	2010-03-11 00:00:00	\N	\N
1449	11	CABO VERDE	2010-03-11 00:00:00	\N	\N
1450	11	CACHOEIRA DA PRATA	2010-03-11 00:00:00	\N	\N
1451	11	CACHOEIRA DE MINAS	2010-03-11 00:00:00	\N	\N
1452	11	CACHOEIRA DE PAJEÚ	2010-03-11 00:00:00	\N	\N
1453	11	CACHOEIRA DOURADA	2010-03-11 00:00:00	\N	\N
1454	11	CAETANÓPOLIS	2010-03-11 00:00:00	\N	\N
1455	11	CAETÉ	2010-03-11 00:00:00	\N	\N
1456	11	CAIANA	2010-03-11 00:00:00	\N	\N
1457	11	CAJURI	2010-03-11 00:00:00	\N	\N
1458	11	CALDAS	2010-03-11 00:00:00	\N	\N
1459	11	CAMACHO	2010-03-11 00:00:00	\N	\N
1460	11	CAMANDUCAIA	2010-03-11 00:00:00	\N	\N
1461	11	CAMBUÍ	2010-03-11 00:00:00	\N	\N
1462	11	CAMBUQUIRA	2010-03-11 00:00:00	\N	\N
1463	11	CAMPANÁRIO	2010-03-11 00:00:00	\N	\N
1464	11	CAMPANHA	2010-03-11 00:00:00	\N	\N
1465	11	CAMPESTRE	2010-03-11 00:00:00	\N	\N
1466	11	CAMPINA VERDE	2010-03-11 00:00:00	\N	\N
1467	11	CAMPO AZUL	2010-03-11 00:00:00	\N	\N
1468	11	CAMPO BELO	2010-03-11 00:00:00	\N	\N
1469	11	CAMPO DO MEIO	2010-03-11 00:00:00	\N	\N
1470	11	CAMPO FLORIDO	2010-03-11 00:00:00	\N	\N
1471	11	CAMPOS ALTOS	2010-03-11 00:00:00	\N	\N
1472	11	CAMPOS GERAIS	2010-03-11 00:00:00	\N	\N
1473	11	CANA VERDE	2010-03-11 00:00:00	\N	\N
1474	11	CANAÃ	2010-03-11 00:00:00	\N	\N
1475	11	CANÁPOLIS	2010-03-11 00:00:00	\N	\N
1476	11	CANDEIAS	2010-03-11 00:00:00	\N	\N
1477	11	CANTAGALO	2010-03-11 00:00:00	\N	\N
1478	11	CAPARAÓ	2010-03-11 00:00:00	\N	\N
1479	11	CAPELA NOVA	2010-03-11 00:00:00	\N	\N
1480	11	CAPELINHA	2010-03-11 00:00:00	\N	\N
1481	11	CAPETINGA	2010-03-11 00:00:00	\N	\N
1482	11	CAPIM BRANCO	2010-03-11 00:00:00	\N	\N
1483	11	CAPINÓPOLIS	2010-03-11 00:00:00	\N	\N
1484	11	CAPITÃO ANDRADE	2010-03-11 00:00:00	\N	\N
1485	11	CAPITÃO ENÉAS	2010-03-11 00:00:00	\N	\N
1486	11	CAPITÓLIO	2010-03-11 00:00:00	\N	\N
1487	11	CAPURITA	2010-03-11 00:00:00	\N	\N
1488	11	CARAÍ	2010-03-11 00:00:00	\N	\N
1489	11	CARANAÍBA	2010-03-11 00:00:00	\N	\N
1490	11	CARANDAÍ	2010-03-11 00:00:00	\N	\N
1491	11	CARANGOLA	2010-03-11 00:00:00	\N	\N
1492	11	CARATINGA	2010-03-11 00:00:00	\N	\N
1493	11	CARBONITA	2010-03-11 00:00:00	\N	\N
1494	11	CAREAÇU	2010-03-11 00:00:00	\N	\N
1495	11	CARLOS CHAGAS	2010-03-11 00:00:00	\N	\N
1496	11	CARMÉSIA	2010-03-11 00:00:00	\N	\N
1497	11	CARMO DA CACHOEIRA	2010-03-11 00:00:00	\N	\N
1498	11	CARMO DA MATA	2010-03-11 00:00:00	\N	\N
1499	11	CARMO DE MINAS	2010-03-11 00:00:00	\N	\N
1500	11	CARMO DO CAJURU	2010-03-11 00:00:00	\N	\N
1501	11	CARMO DO PARANAÍBA	2010-03-11 00:00:00	\N	\N
1502	11	CARMO DO RIO CLARO	2010-03-11 00:00:00	\N	\N
1503	11	CARMÓPOLIS DE MINAS	2010-03-11 00:00:00	\N	\N
1504	11	CARNEIRINHO	2010-03-11 00:00:00	\N	\N
1505	11	CARRANCAS	2010-03-11 00:00:00	\N	\N
1506	11	CARVALHÓPOLIS	2010-03-11 00:00:00	\N	\N
1507	11	CARVALHOS	2010-03-11 00:00:00	\N	\N
1508	11	CASA GRANDE	2010-03-11 00:00:00	\N	\N
1509	11	CASCALHO RICO	2010-03-11 00:00:00	\N	\N
1510	11	CÁSSIA	2010-03-11 00:00:00	\N	\N
1511	11	CATAGUASES	2010-03-11 00:00:00	\N	\N
1512	11	CATAS ALTAS	2010-03-11 00:00:00	\N	\N
1513	11	CATAS ALTAS DA NORUEGA	2010-03-11 00:00:00	\N	\N
1514	11	CATUJI	2010-03-11 00:00:00	\N	\N
1515	11	CATUTI	2010-03-11 00:00:00	\N	\N
1516	11	CAXAMBU	2010-03-11 00:00:00	\N	\N
1517	11	CEDRO DO ABAETÉ	2010-03-11 00:00:00	\N	\N
1518	11	CENTRAL DE MINAS	2010-03-11 00:00:00	\N	\N
1519	11	CENTRALINA	2010-03-11 00:00:00	\N	\N
1520	11	CHÁCARA	2010-03-11 00:00:00	\N	\N
1521	11	CHALE	2010-03-11 00:00:00	\N	\N
1522	11	CHAPADA DO NORTE	2010-03-11 00:00:00	\N	\N
1523	11	CHAPADA GAÚCHA	2010-03-11 00:00:00	\N	\N
1524	11	CHIADOR	2010-03-11 00:00:00	\N	\N
1525	11	CIPOTÂNEA	2010-03-11 00:00:00	\N	\N
1526	11	CLARAVAL	2010-03-11 00:00:00	\N	\N
1527	11	CLARO DOS POÇOES	2010-03-11 00:00:00	\N	\N
1528	11	CLÁUDIO	2010-03-11 00:00:00	\N	\N
1529	11	COIMBRA	2010-03-11 00:00:00	\N	\N
1530	11	COLUNA	2010-03-11 00:00:00	\N	\N
1531	11	COMENDADOR GOMES	2010-03-11 00:00:00	\N	\N
1532	11	COMERCINHO	2010-03-11 00:00:00	\N	\N
1533	11	CONCEIÇÃO DA APARECIDA	2010-03-11 00:00:00	\N	\N
1534	11	CONCEIÇÃO DA BARRA DE MINAS	2010-03-11 00:00:00	\N	\N
1535	11	CONCEIÇÃO DAS ALAGOAS	2010-03-11 00:00:00	\N	\N
1536	11	CONCEIÇÃO DAS PEDRAS	2010-03-11 00:00:00	\N	\N
1537	11	CONCEIÇÃO DE IPANEMA	2010-03-11 00:00:00	\N	\N
1538	11	CONCEIÇÃO DO MATO DENTRO	2010-03-11 00:00:00	\N	\N
1539	11	CONCEIÇÃO DO PARÁ	2010-03-11 00:00:00	\N	\N
1540	11	CONCEIÇÃO DO RIO VERDE	2010-03-11 00:00:00	\N	\N
1541	11	CONCEIÇÃO DOS OUROS	2010-03-11 00:00:00	\N	\N
1542	11	CÔNEGO MARINHO	2010-03-11 00:00:00	\N	\N
1543	11	CONFINS	2010-03-11 00:00:00	\N	\N
1544	11	CONGONHAL	2010-03-11 00:00:00	\N	\N
1545	11	CONGONHAS	2010-03-11 00:00:00	\N	\N
1546	11	CONGONHAS DO NORTE	2010-03-11 00:00:00	\N	\N
1547	11	CONQUISTA	2010-03-11 00:00:00	\N	\N
1548	11	CONSELHEIRO LAFAIETE	2010-03-11 00:00:00	\N	\N
1549	11	CONSELHEIRO PENA	2010-03-11 00:00:00	\N	\N
1550	11	CONSOLAÇÃO	2010-03-11 00:00:00	\N	\N
1551	11	CONTAGEM	2010-03-11 00:00:00	\N	\N
1552	11	COQUEIRAL	2010-03-11 00:00:00	\N	\N
1553	11	CORAÇÃO DE JESUS	2010-03-11 00:00:00	\N	\N
1554	11	CORDISBURGO	2010-03-11 00:00:00	\N	\N
1555	11	CORDISLÂNDIA	2010-03-11 00:00:00	\N	\N
1556	11	CORINTO	2010-03-11 00:00:00	\N	\N
1557	11	COROACI	2010-03-11 00:00:00	\N	\N
1558	11	COROMANDEL	2010-03-11 00:00:00	\N	\N
1559	11	CORONEL FABRICIANO	2010-03-11 00:00:00	\N	\N
1560	11	CORONEL MURTA	2010-03-11 00:00:00	\N	\N
1561	11	CORONEL PACHECO	2010-03-11 00:00:00	\N	\N
1562	11	CORONEL XAVIER CHAVES	2010-03-11 00:00:00	\N	\N
1563	11	CÓRREGO DANTA	2010-03-11 00:00:00	\N	\N
1564	11	CÓRREGO DO BOM JESUS	2010-03-11 00:00:00	\N	\N
1565	11	CÓRREGO FUNDO	2010-03-11 00:00:00	\N	\N
1566	11	CÓRREGO NOVO	2010-03-11 00:00:00	\N	\N
1567	11	COUTO DE MAGALHÃES DE MINAS	2010-03-11 00:00:00	\N	\N
1568	11	CRISÓLITA	2010-03-11 00:00:00	\N	\N
1569	11	CRISTAIS	2010-03-11 00:00:00	\N	\N
1570	11	CRISTÁLIA	2010-03-11 00:00:00	\N	\N
1571	11	CRISTIANO OTONI	2010-03-11 00:00:00	\N	\N
1572	11	CRISTINA	2010-03-11 00:00:00	\N	\N
1573	11	CRUCILÂNDIA	2010-03-11 00:00:00	\N	\N
1574	11	CRUZEIRO DA FORTALEZA	2010-03-11 00:00:00	\N	\N
1575	11	CRUZÍLIA	2010-03-11 00:00:00	\N	\N
1576	11	CUPARAQUE	2010-03-11 00:00:00	\N	\N
1577	11	CURRAL DE DENTRO	2010-03-11 00:00:00	\N	\N
1578	11	CURVELO	2010-03-11 00:00:00	\N	\N
1579	11	DATAS	2010-03-11 00:00:00	\N	\N
1580	11	DELFIM MOREIRA	2010-03-11 00:00:00	\N	\N
1581	11	DELFINÓPOLIS	2010-03-11 00:00:00	\N	\N
1582	11	DELTA	2010-03-11 00:00:00	\N	\N
1583	11	DESCOBERTO	2010-03-11 00:00:00	\N	\N
1584	11	DESTERRO DE ENTRE RIOS	2010-03-11 00:00:00	\N	\N
1585	11	DESTERRO DO MELO	2010-03-11 00:00:00	\N	\N
1586	11	DIAMANTINA	2010-03-11 00:00:00	\N	\N
1587	11	DIOGO DE VASCONCELOS	2010-03-11 00:00:00	\N	\N
1588	11	DIONÍSIO	2010-03-11 00:00:00	\N	\N
1589	11	DIVINÉSIA	2010-03-11 00:00:00	\N	\N
1590	11	DIVINO	2010-03-11 00:00:00	\N	\N
1591	11	DIVINO DAS LARANJEIRAS	2010-03-11 00:00:00	\N	\N
1592	11	DIVINOLÂNDIA DE MINAS	2010-03-11 00:00:00	\N	\N
1593	11	DIVINÓPOLIS	2010-03-11 00:00:00	\N	\N
1594	11	DIVISA ALEGRE	2010-03-11 00:00:00	\N	\N
1595	11	DIVISA NOVA	2010-03-11 00:00:00	\N	\N
1596	11	DIVISÓPOLIS	2010-03-11 00:00:00	\N	\N
1597	11	DOM BOSCO	2010-03-11 00:00:00	\N	\N
1598	11	DOM CAVATI	2010-03-11 00:00:00	\N	\N
1599	11	DOM JOAQUIM	2010-03-11 00:00:00	\N	\N
1600	11	DOM SILVÉRIO	2010-03-11 00:00:00	\N	\N
1601	11	DOM VIÇOSO	2010-03-11 00:00:00	\N	\N
1602	11	DONA EUZÉBIA	2010-03-11 00:00:00	\N	\N
1603	11	DORES DE CAMPOS	2010-03-11 00:00:00	\N	\N
1604	11	DORES DE GUANHÃES	2010-03-11 00:00:00	\N	\N
1605	11	DORES DO INDAIÁ	2010-03-11 00:00:00	\N	\N
1606	11	DORES DO TURVO	2010-03-11 00:00:00	\N	\N
1607	11	DORESÓPOLIS	2010-03-11 00:00:00	\N	\N
1608	11	DOURADOQUARA	2010-03-11 00:00:00	\N	\N
1609	11	DURANDE	2010-03-11 00:00:00	\N	\N
1610	11	ELÓI MENDES	2010-03-11 00:00:00	\N	\N
1611	11	ENGENHEIRO CALDAS	2010-03-11 00:00:00	\N	\N
1612	11	ENGENHEIRO NAVARRO	2010-03-11 00:00:00	\N	\N
1613	11	ENTRE FOLHAS	2010-03-11 00:00:00	\N	\N
1614	11	ENTRE RIOS DE MINAS	2010-03-11 00:00:00	\N	\N
1615	11	ERVÁLIA	2010-03-11 00:00:00	\N	\N
1616	11	ESMERALDAS	2010-03-11 00:00:00	\N	\N
1617	11	ESPERA FELIZ	2010-03-11 00:00:00	\N	\N
1618	11	ESPINOSA	2010-03-11 00:00:00	\N	\N
1619	11	ESPÍRITO SANTO DO DOURADO	2010-03-11 00:00:00	\N	\N
1620	11	ESTIVA	2010-03-11 00:00:00	\N	\N
1621	11	ESTRELA DALVA	2010-03-11 00:00:00	\N	\N
1622	11	ESTRELA DO INDAIÁ	2010-03-11 00:00:00	\N	\N
1623	11	ESTRELA DO SUL	2010-03-11 00:00:00	\N	\N
1624	11	EUGENÓPOLIS	2010-03-11 00:00:00	\N	\N
1625	11	EWBANK DA CÂMARA	2010-03-11 00:00:00	\N	\N
1626	11	EXTREMA	2010-03-11 00:00:00	\N	\N
1627	11	FAMA	2010-03-11 00:00:00	\N	\N
1628	11	FARIA LEMOS	2010-03-11 00:00:00	\N	\N
1629	11	FELÍCIO DOS SANTOS	2010-03-11 00:00:00	\N	\N
1630	11	FELISBURGO	2010-03-11 00:00:00	\N	\N
1631	11	FELIXLÂNDIA	2010-03-11 00:00:00	\N	\N
1632	11	FERNANDES TOURINHO	2010-03-11 00:00:00	\N	\N
1633	11	FERROS	2010-03-11 00:00:00	\N	\N
1634	11	FERVEDOURO	2010-03-11 00:00:00	\N	\N
1635	11	FLORESTAL	2010-03-11 00:00:00	\N	\N
1636	11	FORMIGA	2010-03-11 00:00:00	\N	\N
1637	11	FORMOSO	2010-03-11 00:00:00	\N	\N
1638	11	FORTALEZA DE MINAS	2010-03-11 00:00:00	\N	\N
1639	11	FORTUNA DE MINAS	2010-03-11 00:00:00	\N	\N
1640	11	FRANCISCO BADARÓ	2010-03-11 00:00:00	\N	\N
1641	11	FRANCISCO DUMONT	2010-03-11 00:00:00	\N	\N
1642	11	FRANCISCO SÁ	2010-03-11 00:00:00	\N	\N
1643	11	FRANCISCÓPOLIS	2010-03-11 00:00:00	\N	\N
1644	11	FREI GASPAR	2010-03-11 00:00:00	\N	\N
1645	11	FREI INOCÊNCIO	2010-03-11 00:00:00	\N	\N
1646	11	FREI LAGONEGRO	2010-03-11 00:00:00	\N	\N
1647	11	FRONTEIRA	2010-03-11 00:00:00	\N	\N
1648	11	FRONTEIRA DOS VALES	2010-03-11 00:00:00	\N	\N
1649	11	FRUTA DE LEITE	2010-03-11 00:00:00	\N	\N
1650	11	FRUTAL	2010-03-11 00:00:00	\N	\N
1651	11	FUNILÂNDIA	2010-03-11 00:00:00	\N	\N
1652	11	GALILÉIA	2010-03-11 00:00:00	\N	\N
1653	11	GAMELEIRAS	2010-03-11 00:00:00	\N	\N
1654	11	GLAUCILÂNDIA	2010-03-11 00:00:00	\N	\N
1655	11	GOIABEIRA	2010-03-11 00:00:00	\N	\N
1656	11	GOIANÁ	2010-03-11 00:00:00	\N	\N
1657	11	GONÇALVES	2010-03-11 00:00:00	\N	\N
1658	11	GONZAGA	2010-03-11 00:00:00	\N	\N
1659	11	GOUVEIA	2010-03-11 00:00:00	\N	\N
1660	11	GOVERNADOR VALADARES	2010-03-11 00:00:00	\N	\N
1661	11	GRÃO MOGOL	2010-03-11 00:00:00	\N	\N
1662	11	GRUPIARA	2010-03-11 00:00:00	\N	\N
1663	11	GUANHÃES	2010-03-11 00:00:00	\N	\N
1664	11	GUAPÉ	2010-03-11 00:00:00	\N	\N
1665	11	GUARACIABA	2010-03-11 00:00:00	\N	\N
1666	11	GUARACIAMA	2010-03-11 00:00:00	\N	\N
1667	11	GUARANÉSIA	2010-03-11 00:00:00	\N	\N
1668	11	GUARANI	2010-03-11 00:00:00	\N	\N
1669	11	GUARARA	2010-03-11 00:00:00	\N	\N
1670	11	GUARDA-MOR	2010-03-11 00:00:00	\N	\N
1671	11	GUAXUPÉ	2010-03-11 00:00:00	\N	\N
1672	11	GUIDOVAL	2010-03-11 00:00:00	\N	\N
1673	11	GUIMARÂNIA	2010-03-11 00:00:00	\N	\N
1674	11	GUIRICEMA	2010-03-11 00:00:00	\N	\N
1675	11	GURINHATÃ	2010-03-11 00:00:00	\N	\N
1676	11	HELIODORA	2010-03-11 00:00:00	\N	\N
1677	11	IAPU	2010-03-11 00:00:00	\N	\N
1678	11	IBERTIOGA	2010-03-11 00:00:00	\N	\N
1679	11	IBIA	2010-03-11 00:00:00	\N	\N
1680	11	IBIAI	2010-03-11 00:00:00	\N	\N
1681	11	IBIRACATU	2010-03-11 00:00:00	\N	\N
1682	11	IBIRACI	2010-03-11 00:00:00	\N	\N
1683	11	IBIRITÉ	2010-03-11 00:00:00	\N	\N
1684	11	IBITIÚRA DE MINAS	2010-03-11 00:00:00	\N	\N
1685	11	IBITURUNA	2010-03-11 00:00:00	\N	\N
1686	11	ICARAÍ DE MINAS	2010-03-11 00:00:00	\N	\N
1687	11	IGARAPÉ	2010-03-11 00:00:00	\N	\N
1688	11	IGARATINGA	2010-03-11 00:00:00	\N	\N
1689	11	IGUATAMA	2010-03-11 00:00:00	\N	\N
1690	11	IJACI	2010-03-11 00:00:00	\N	\N
1691	11	ILICINEA	2010-03-11 00:00:00	\N	\N
1692	11	IMBÉ DE MINAS	2010-03-11 00:00:00	\N	\N
1693	11	INCONFIDENTES	2010-03-11 00:00:00	\N	\N
1694	11	INDAIABIRA	2010-03-11 00:00:00	\N	\N
1695	11	INDIANÓPOLIS	2010-03-11 00:00:00	\N	\N
1696	11	INGAI	2010-03-11 00:00:00	\N	\N
1697	11	INHAPIM	2010-03-11 00:00:00	\N	\N
1698	11	INHAUMA	2010-03-11 00:00:00	\N	\N
1699	11	INIMUTABA	2010-03-11 00:00:00	\N	\N
1700	11	IPABA	2010-03-11 00:00:00	\N	\N
1701	11	IPANEMA	2010-03-11 00:00:00	\N	\N
1702	11	IPATINGA	2010-03-11 00:00:00	\N	\N
1703	11	IPIAÇU	2010-03-11 00:00:00	\N	\N
1704	11	IPUIUNA	2010-03-11 00:00:00	\N	\N
1705	11	IRAÍ DE MINAS	2010-03-11 00:00:00	\N	\N
1706	11	ITABIRA	2010-03-11 00:00:00	\N	\N
1707	11	ITABIRINHA DE MANTENA	2010-03-11 00:00:00	\N	\N
1708	11	ITABIRITO	2010-03-11 00:00:00	\N	\N
1709	11	ITACAMBIRA	2010-03-11 00:00:00	\N	\N
1710	11	ITACARAMBI	2010-03-11 00:00:00	\N	\N
1711	11	ITAGUARA	2010-03-11 00:00:00	\N	\N
1712	11	ITAÍPE	2010-03-11 00:00:00	\N	\N
1713	11	ITAJUBÁ	2010-03-11 00:00:00	\N	\N
1714	11	ITAMARANDIBA	2010-03-11 00:00:00	\N	\N
1715	11	ITAMARATI DE MINAS	2010-03-11 00:00:00	\N	\N
1716	11	ITAMBACURI	2010-03-11 00:00:00	\N	\N
1717	11	ITAMBÉ DO MATO DENTRO	2010-03-11 00:00:00	\N	\N
1718	11	ITAMOGI	2010-03-11 00:00:00	\N	\N
1719	11	ITAMONTE	2010-03-11 00:00:00	\N	\N
1720	11	ITANHANDU	2010-03-11 00:00:00	\N	\N
1721	11	ITANHOMI	2010-03-11 00:00:00	\N	\N
1722	11	ITAOBIM	2010-03-11 00:00:00	\N	\N
1723	11	ITAPAGIPE	2010-03-11 00:00:00	\N	\N
1724	11	ITAPECERICA	2010-03-11 00:00:00	\N	\N
1725	11	ITAPEVA	2010-03-11 00:00:00	\N	\N
1726	11	ITATIAIUÇU	2010-03-11 00:00:00	\N	\N
1727	11	ITAÚ DE MINAS	2010-03-11 00:00:00	\N	\N
1728	11	ITAÚNA	2010-03-11 00:00:00	\N	\N
1729	11	ITAVERAVA	2010-03-11 00:00:00	\N	\N
1730	11	ITINGA	2010-03-11 00:00:00	\N	\N
1731	11	ITUETA	2010-03-11 00:00:00	\N	\N
1732	11	ITUIUTABA	2010-03-11 00:00:00	\N	\N
1733	11	ITUMIRIM	2010-03-11 00:00:00	\N	\N
1734	11	ITURAMA	2010-03-11 00:00:00	\N	\N
1735	11	ITUTINGA	2010-03-11 00:00:00	\N	\N
1736	11	JABOTICATUBAS	2010-03-11 00:00:00	\N	\N
1737	11	JACINTO	2010-03-11 00:00:00	\N	\N
1738	11	JACUÍ	2010-03-11 00:00:00	\N	\N
1739	11	JACUTINGA	2010-03-11 00:00:00	\N	\N
1740	11	JAGUARAÇU	2010-03-11 00:00:00	\N	\N
1741	11	JAÍBA	2010-03-11 00:00:00	\N	\N
1742	11	JAMPRUCA	2010-03-11 00:00:00	\N	\N
1743	11	JANAÚBA	2010-03-11 00:00:00	\N	\N
1744	11	JANUÁRIA	2010-03-11 00:00:00	\N	\N
1745	11	JAPARAÍBA	2010-03-11 00:00:00	\N	\N
1746	11	JAPONVAR	2010-03-11 00:00:00	\N	\N
1747	11	JECEABA	2010-03-11 00:00:00	\N	\N
1748	11	JENIPAPO DE MINAS	2010-03-11 00:00:00	\N	\N
1749	11	JEQUERI	2010-03-11 00:00:00	\N	\N
1750	11	JEQUITAÍ	2010-03-11 00:00:00	\N	\N
1751	11	JEQUITIBÁ	2010-03-11 00:00:00	\N	\N
1752	11	JEQUITINHONHA	2010-03-11 00:00:00	\N	\N
1753	11	JESUÂNIA	2010-03-11 00:00:00	\N	\N
1754	11	JOAIMA	2010-03-11 00:00:00	\N	\N
1755	11	JOANÉSIA	2010-03-11 00:00:00	\N	\N
1756	11	JOÃO MONLEVADE	2010-03-11 00:00:00	\N	\N
1757	11	JOÃO PINHEIRO	2010-03-11 00:00:00	\N	\N
1758	11	JOAQUIM FELÍCIO	2010-03-11 00:00:00	\N	\N
1759	11	JORDÂNIA	2010-03-11 00:00:00	\N	\N
1760	11	JOSÉ GONÇALVES DE MINAS	2010-03-11 00:00:00	\N	\N
1761	11	JOSÉ RAYDAN	2010-03-11 00:00:00	\N	\N
1762	11	JOSENÓPOLIS	2010-03-11 00:00:00	\N	\N
1763	11	JUATUBA	2010-03-11 00:00:00	\N	\N
1764	11	JUIZ DE FORA	2010-03-11 00:00:00	\N	\N
1765	11	JURAMENTO	2010-03-11 00:00:00	\N	\N
1766	11	JURUAIA	2010-03-11 00:00:00	\N	\N
1767	11	JUVENILIA	2010-03-11 00:00:00	\N	\N
1768	11	LADAINHA	2010-03-11 00:00:00	\N	\N
1769	11	LAGAMAR	2010-03-11 00:00:00	\N	\N
1770	11	LAGOA DA PRATA	2010-03-11 00:00:00	\N	\N
1771	11	LAGOA DOS PATOS	2010-03-11 00:00:00	\N	\N
1772	11	LAGOA DOURADA	2010-03-11 00:00:00	\N	\N
1773	11	LAGOA FORMOSA	2010-03-11 00:00:00	\N	\N
1774	11	LAGOA GRANDE	2010-03-11 00:00:00	\N	\N
1775	11	LAGOA SANTA	2010-03-11 00:00:00	\N	\N
1776	11	LAJINHA	2010-03-11 00:00:00	\N	\N
1777	11	LAMBARI	2010-03-11 00:00:00	\N	\N
1778	11	LAMIM	2010-03-11 00:00:00	\N	\N
1779	11	LARANJAL	2010-03-11 00:00:00	\N	\N
1780	11	LASSANCE	2010-03-11 00:00:00	\N	\N
1781	11	LAVRAS	2010-03-11 00:00:00	\N	\N
1782	11	LEANDRO FERREIRA	2010-03-11 00:00:00	\N	\N
1783	11	LEME DO PRADO	2010-03-11 00:00:00	\N	\N
1784	11	LEOPOLDINA	2010-03-11 00:00:00	\N	\N
1785	11	LIBERDADE	2010-03-11 00:00:00	\N	\N
1786	11	LIMA DUARTE	2010-03-11 00:00:00	\N	\N
1787	11	LIMEIRA DO OESTE	2010-03-11 00:00:00	\N	\N
1788	11	LONTRA	2010-03-11 00:00:00	\N	\N
1789	11	LUISLÂNDIA	2010-03-11 00:00:00	\N	\N
1790	11	LUIZBURGO	2010-03-11 00:00:00	\N	\N
1791	11	LUMINÁRIAS	2010-03-11 00:00:00	\N	\N
1792	11	LUZ	2010-03-11 00:00:00	\N	\N
1793	11	MACHACALIS	2010-03-11 00:00:00	\N	\N
1794	11	MACHADO	2010-03-11 00:00:00	\N	\N
1795	11	MADRE DE DEUS DE MINAS	2010-03-11 00:00:00	\N	\N
1796	11	MALACACHETA	2010-03-11 00:00:00	\N	\N
1797	11	MAMONAS	2010-03-11 00:00:00	\N	\N
1798	11	MANGA	2010-03-11 00:00:00	\N	\N
1799	11	MANHUAÇU	2010-03-11 00:00:00	\N	\N
1800	11	MANHUMIRIM	2010-03-11 00:00:00	\N	\N
1801	11	MANTENA	2010-03-11 00:00:00	\N	\N
1802	11	MAR DE ESPANHA	2010-03-11 00:00:00	\N	\N
1803	11	MARAVILHAS	2010-03-11 00:00:00	\N	\N
1804	11	MARIA DA FÉ	2010-03-11 00:00:00	\N	\N
1805	11	MARIANA	2010-03-11 00:00:00	\N	\N
1806	11	MARILAC	2010-03-11 00:00:00	\N	\N
1807	11	MÁRIO CAMPOS	2010-03-11 00:00:00	\N	\N
1808	11	MARIPA DE MINAS	2010-03-11 00:00:00	\N	\N
1809	11	MARLIÉRIA	2010-03-11 00:00:00	\N	\N
1810	11	MARMELÓPOLIS	2010-03-11 00:00:00	\N	\N
1811	11	MARTINHO CAMPOS	2010-03-11 00:00:00	\N	\N
1812	11	MARTINS SOARES	2010-03-11 00:00:00	\N	\N
1813	11	MATA VERDE	2010-03-11 00:00:00	\N	\N
1814	11	MATERLÂNDIA	2010-03-11 00:00:00	\N	\N
1815	11	MATEUS LEME	2010-03-11 00:00:00	\N	\N
1816	11	MATHIAS LOBATO	2010-03-11 00:00:00	\N	\N
1817	11	MATIAS BARBOSA	2010-03-11 00:00:00	\N	\N
1818	11	MATIAS CARDOSO	2010-03-11 00:00:00	\N	\N
1819	11	MATIPÓ	2010-03-11 00:00:00	\N	\N
1820	11	MATO VERDE	2010-03-11 00:00:00	\N	\N
1821	11	MATOZINHOS	2010-03-11 00:00:00	\N	\N
1822	11	MATUTINA	2010-03-11 00:00:00	\N	\N
1823	11	MEDEIROS	2010-03-11 00:00:00	\N	\N
1824	11	MEDINA	2010-03-11 00:00:00	\N	\N
1825	11	MENDES PIMENTEL	2010-03-11 00:00:00	\N	\N
1826	11	MERCÊS	2010-03-11 00:00:00	\N	\N
1827	11	MESQUITA	2010-03-11 00:00:00	\N	\N
1828	11	MINAS NOVAS	2010-03-11 00:00:00	\N	\N
1829	11	MINDURI	2010-03-11 00:00:00	\N	\N
1830	11	MIRABELA	2010-03-11 00:00:00	\N	\N
1831	11	MIRADOURO	2010-03-11 00:00:00	\N	\N
1832	11	MIRAÍ	2010-03-11 00:00:00	\N	\N
1833	11	MIRAVÂNIA	2010-03-11 00:00:00	\N	\N
1834	11	MOEDA	2010-03-11 00:00:00	\N	\N
1835	11	MOEMA	2010-03-11 00:00:00	\N	\N
1836	11	MONJOLOS	2010-03-11 00:00:00	\N	\N
1837	11	MONSENHOR PAULO	2010-03-11 00:00:00	\N	\N
1838	11	MONTALVÂNIA	2010-03-11 00:00:00	\N	\N
1839	11	MONTE ALEGRE DE MINAS	2010-03-11 00:00:00	\N	\N
1840	11	MONTE AZUL	2010-03-11 00:00:00	\N	\N
1841	11	MONTE BELO	2010-03-11 00:00:00	\N	\N
1842	11	MONTE CARMELO	2010-03-11 00:00:00	\N	\N
1843	11	MONTE FORMOSO	2010-03-11 00:00:00	\N	\N
1844	11	MONTE SANTO DE MINAS	2010-03-11 00:00:00	\N	\N
1845	11	MONTE SIÃO	2010-03-11 00:00:00	\N	\N
1846	11	MONTES CLAROS	2010-03-11 00:00:00	\N	\N
1847	11	MONTEZUMA	2010-03-11 00:00:00	\N	\N
1848	11	MORADA NOVA DE MINAS	2010-03-11 00:00:00	\N	\N
1849	11	MORRO DO GARÇA	2010-03-11 00:00:00	\N	\N
1850	11	MORRO DO PILAR	2010-03-11 00:00:00	\N	\N
1851	11	MUNHOZ	2010-03-11 00:00:00	\N	\N
1852	11	MURIAÉ	2010-03-11 00:00:00	\N	\N
1853	11	MUTUM	2010-03-11 00:00:00	\N	\N
1854	11	MUZAMBINHO	2010-03-11 00:00:00	\N	\N
1855	11	NACIP RAYDAN	2010-03-11 00:00:00	\N	\N
1856	11	NANUQUE	2010-03-11 00:00:00	\N	\N
1857	11	NAQUE	2010-03-11 00:00:00	\N	\N
1858	11	NATALÂNDIA	2010-03-11 00:00:00	\N	\N
1859	11	NATÉRCIA	2010-03-11 00:00:00	\N	\N
1860	11	NAZARENO	2010-03-11 00:00:00	\N	\N
1861	11	NEPOMUCENO	2010-03-11 00:00:00	\N	\N
1862	11	NINHEIRA	2010-03-11 00:00:00	\N	\N
1863	11	NOVA BELÉM	2010-03-11 00:00:00	\N	\N
1864	11	NOVA ERA	2010-03-11 00:00:00	\N	\N
1865	11	NOVA LIMA	2010-03-11 00:00:00	\N	\N
1866	11	NOVA MÓDICA	2010-03-11 00:00:00	\N	\N
1867	11	NOVA PONTE	2010-03-11 00:00:00	\N	\N
1868	11	NOVA PORTEIRINHA	2010-03-11 00:00:00	\N	\N
1869	11	NOVA RESENDE	2010-03-11 00:00:00	\N	\N
1870	11	NOVA SERRANA	2010-03-11 00:00:00	\N	\N
1871	11	NOVA UNIÃO	2010-03-11 00:00:00	\N	\N
1872	11	NOVO CRUZEIRO	2010-03-11 00:00:00	\N	\N
1873	11	NOVO ORIENTE DE MINAS	2010-03-11 00:00:00	\N	\N
1874	11	NOVORIZONTE	2010-03-11 00:00:00	\N	\N
1875	11	OLARIA	2010-03-11 00:00:00	\N	\N
1876	11	OLHOS D ÁGUA	2010-03-11 00:00:00	\N	\N
1877	11	OLÍMPIO NORONHA	2010-03-11 00:00:00	\N	\N
1878	11	OLIVEIRA	2010-03-11 00:00:00	\N	\N
1879	11	OLIVEIRA FORTES	2010-03-11 00:00:00	\N	\N
1880	11	ONÇA DE PITANGUI	2010-03-11 00:00:00	\N	\N
1881	11	ORATÓRIOS	2010-03-11 00:00:00	\N	\N
1882	11	ORIZÂNIA	2010-03-11 00:00:00	\N	\N
1883	11	OURO BRANCO	2010-03-11 00:00:00	\N	\N
1884	11	OURO FINO	2010-03-11 00:00:00	\N	\N
1885	11	OURO PRETO	2010-03-11 00:00:00	\N	\N
1886	11	OURO VERDE DE MINAS	2010-03-11 00:00:00	\N	\N
1887	11	PADRE CARVALHO	2010-03-11 00:00:00	\N	\N
1888	11	PADRE PARAÍSO	2010-03-11 00:00:00	\N	\N
1889	11	PAI PEDRO	2010-03-11 00:00:00	\N	\N
1890	11	PAINEIRAS	2010-03-11 00:00:00	\N	\N
1891	11	PAINS	2010-03-11 00:00:00	\N	\N
1892	11	PAIVA	2010-03-11 00:00:00	\N	\N
1893	11	PALMA	2010-03-11 00:00:00	\N	\N
1894	11	PALMÓPOLIS	2010-03-11 00:00:00	\N	\N
1895	11	PAPAGAIOS	2010-03-11 00:00:00	\N	\N
1896	11	PARÁ DE MINAS	2010-03-11 00:00:00	\N	\N
1897	11	PARACATU	2010-03-11 00:00:00	\N	\N
1898	11	PARAGUAÇU	2010-03-11 00:00:00	\N	\N
1899	11	PARAISÓPOLIS	2010-03-11 00:00:00	\N	\N
1900	11	PARAOPEBA	2010-03-11 00:00:00	\N	\N
1901	11	PASSA QUATRO	2010-03-11 00:00:00	\N	\N
1902	11	PASSA TEMPO	2010-03-11 00:00:00	\N	\N
1903	11	PASSA VINTE	2010-03-11 00:00:00	\N	\N
1904	11	PASSABEM	2010-03-11 00:00:00	\N	\N
1905	11	PASSOS	2010-03-11 00:00:00	\N	\N
1906	11	PATIS	2010-03-11 00:00:00	\N	\N
1907	11	PATOS DE MINAS	2010-03-11 00:00:00	\N	\N
1908	11	PATROCÍNIO	2010-03-11 00:00:00	\N	\N
1909	11	PATROCÍNIO DO MURIAÉ	2010-03-11 00:00:00	\N	\N
1910	11	PAULA CÂNDIDO	2010-03-11 00:00:00	\N	\N
1911	11	PAULISTAS	2010-03-11 00:00:00	\N	\N
1912	11	PAVÃO	2010-03-11 00:00:00	\N	\N
1913	11	PEÇANHA	2010-03-11 00:00:00	\N	\N
1914	11	PEDRA AZUL	2010-03-11 00:00:00	\N	\N
1915	11	PEDRA BONITA	2010-03-11 00:00:00	\N	\N
1916	11	PEDRA DO ANTA	2010-03-11 00:00:00	\N	\N
1917	11	PEDRA DO INDAIÁ	2010-03-11 00:00:00	\N	\N
1918	11	PEDRA DOURADA	2010-03-11 00:00:00	\N	\N
1919	11	PEDRALVA	2010-03-11 00:00:00	\N	\N
1920	11	PEDRAS DE MARIA DA CRUZ	2010-03-11 00:00:00	\N	\N
1921	11	PEDRINÓPOLIS	2010-03-11 00:00:00	\N	\N
1922	11	PEDRO LEOPOLDO	2010-03-11 00:00:00	\N	\N
1923	11	PEDRO TEIXEIRA	2010-03-11 00:00:00	\N	\N
1924	11	PEQUERI	2010-03-11 00:00:00	\N	\N
1925	11	PEQUI	2010-03-11 00:00:00	\N	\N
1926	11	PERDIGÃO	2010-03-11 00:00:00	\N	\N
1927	11	PERDIZES	2010-03-11 00:00:00	\N	\N
1928	11	PERDÕES	2010-03-11 00:00:00	\N	\N
1929	11	PERIQUITO	2010-03-11 00:00:00	\N	\N
1930	11	PESCADOR	2010-03-11 00:00:00	\N	\N
1931	11	PIAU	2010-03-11 00:00:00	\N	\N
1932	11	PIEDADE DE CARATINGA	2010-03-11 00:00:00	\N	\N
1933	11	PIEDADE DE PONTE NOVA	2010-03-11 00:00:00	\N	\N
1934	11	PIEDADE DO RIO GRANDE	2010-03-11 00:00:00	\N	\N
1935	11	PIEDADE DOS GERAIS	2010-03-11 00:00:00	\N	\N
1936	11	PIMENTA	2010-03-11 00:00:00	\N	\N
1937	11	PINGO D  ÁGUA	2010-03-11 00:00:00	\N	\N
1938	11	PINTÓPOLIS	2010-03-11 00:00:00	\N	\N
1939	11	PIRACEMA	2010-03-11 00:00:00	\N	\N
1940	11	PIRAJUBA	2010-03-11 00:00:00	\N	\N
1941	11	PIRANGA	2010-03-11 00:00:00	\N	\N
1942	11	PIRANGUÇU	2010-03-11 00:00:00	\N	\N
1943	11	PIRANGUINHO	2010-03-11 00:00:00	\N	\N
1944	11	PIRAPETINGA	2010-03-11 00:00:00	\N	\N
1945	11	PIRAPORA	2010-03-11 00:00:00	\N	\N
1946	11	PIRAÚBA	2010-03-11 00:00:00	\N	\N
1947	11	PITANGUI	2010-03-11 00:00:00	\N	\N
1948	11	PIUMHI	2010-03-11 00:00:00	\N	\N
1949	11	PLANURA	2010-03-11 00:00:00	\N	\N
1950	11	POÇO FUNDO	2010-03-11 00:00:00	\N	\N
1951	11	POÇOS DE CALDAS	2010-03-11 00:00:00	\N	\N
1952	11	POCRANE	2010-03-11 00:00:00	\N	\N
1953	11	POMPEU	2010-03-11 00:00:00	\N	\N
1954	11	PONTE NOVA	2010-03-11 00:00:00	\N	\N
1955	11	PONTO CHIQUE	2010-03-11 00:00:00	\N	\N
1956	11	PONTO DOS VOLANTES	2010-03-11 00:00:00	\N	\N
1957	11	PORTEIRINHA	2010-03-11 00:00:00	\N	\N
1958	11	PORTO FIRME	2010-03-11 00:00:00	\N	\N
1959	11	POTE	2010-03-11 00:00:00	\N	\N
1960	11	POUSO ALEGRE	2010-03-11 00:00:00	\N	\N
1961	11	POUSO ALTO	2010-03-11 00:00:00	\N	\N
1962	11	PRADOS	2010-03-11 00:00:00	\N	\N
1963	11	PRATA	2010-03-11 00:00:00	\N	\N
1964	11	PRATÁPOLIS	2010-03-11 00:00:00	\N	\N
1965	11	PRATINHA	2010-03-11 00:00:00	\N	\N
1966	11	PRESIDENTE BERNARDES	2010-03-11 00:00:00	\N	\N
1967	11	PRESIDENTE JUSCELINO	2010-03-11 00:00:00	\N	\N
1968	11	PRESIDENTE KUBITSCHEK	2010-03-11 00:00:00	\N	\N
1969	11	PRESIDENTE OLEGÁRIO	2010-03-11 00:00:00	\N	\N
1970	11	PRUDENTE DE MORAIS	2010-03-11 00:00:00	\N	\N
1971	11	QUARTEL GERAL	2010-03-11 00:00:00	\N	\N
1972	11	QUELUZITO	2010-03-11 00:00:00	\N	\N
1973	11	RAPOSOS	2010-03-11 00:00:00	\N	\N
1974	11	RAUL SOARES	2010-03-11 00:00:00	\N	\N
1975	11	RECREIO	2010-03-11 00:00:00	\N	\N
1976	11	REDUTO	2010-03-11 00:00:00	\N	\N
1977	11	RESENDE COSTA	2010-03-11 00:00:00	\N	\N
1978	11	RESPLENDOR	2010-03-11 00:00:00	\N	\N
1979	11	RESSAQUINHA	2010-03-11 00:00:00	\N	\N
1980	11	RIACHINHO	2010-03-11 00:00:00	\N	\N
1981	11	RIACHO DOS MACHADOS	2010-03-11 00:00:00	\N	\N
1982	11	RIBEIRÃO DAS NEVES	2010-03-11 00:00:00	\N	\N
1983	11	RIBEIRÃO VERMELHO	2010-03-11 00:00:00	\N	\N
1984	11	RIO ACIMA	2010-03-11 00:00:00	\N	\N
1985	11	RIO CASCA	2010-03-11 00:00:00	\N	\N
1986	11	RIO DO PRADO	2010-03-11 00:00:00	\N	\N
1987	11	RIO DOCE	2010-03-11 00:00:00	\N	\N
1988	11	RIO ESPERA	2010-03-11 00:00:00	\N	\N
1989	11	RIO MANSO	2010-03-11 00:00:00	\N	\N
1990	11	RIO NOVO	2010-03-11 00:00:00	\N	\N
1991	11	RIO PARANAÍBA	2010-03-11 00:00:00	\N	\N
1992	11	RIO PARDO DE MINAS	2010-03-11 00:00:00	\N	\N
1993	11	RIO PIRACICABA	2010-03-11 00:00:00	\N	\N
1994	11	RIO POMBA	2010-03-11 00:00:00	\N	\N
1995	11	RIO PRETO	2010-03-11 00:00:00	\N	\N
1996	11	RIO VERMELHO	2010-03-11 00:00:00	\N	\N
1997	11	RITÁPOLIS	2010-03-11 00:00:00	\N	\N
1998	11	ROCHEDO DE MINAS	2010-03-11 00:00:00	\N	\N
1999	11	RODEIRO	2010-03-11 00:00:00	\N	\N
2000	11	ROMARIA	2010-03-11 00:00:00	\N	\N
2001	11	ROSÁRIO DA LIMEIRA	2010-03-11 00:00:00	\N	\N
2002	11	RUBELITA	2010-03-11 00:00:00	\N	\N
2003	11	RUBIM	2010-03-11 00:00:00	\N	\N
2004	11	SABARÁ	2010-03-11 00:00:00	\N	\N
2005	11	SABINÓPOLIS	2010-03-11 00:00:00	\N	\N
2006	11	SACRAMENTO	2010-03-11 00:00:00	\N	\N
2007	11	SALINAS	2010-03-11 00:00:00	\N	\N
2008	11	SALTO DA DIVISA	2010-03-11 00:00:00	\N	\N
2009	11	SANTA BÁRBARA	2010-03-11 00:00:00	\N	\N
2010	11	SANTA BÁRBARA DO LESTE	2010-03-11 00:00:00	\N	\N
2011	11	SANTA BÁRBARA DO MONTE VERDE	2010-03-11 00:00:00	\N	\N
2012	11	SANTA BÁRBARA DO TUGÚRIO	2010-03-11 00:00:00	\N	\N
2013	11	SANTA CRUZ DE MINAS	2010-03-11 00:00:00	\N	\N
2014	11	SANTA CRUZ DE SALINAS	2010-03-11 00:00:00	\N	\N
2015	11	SANTA CRUZ DO ESCALVADO	2010-03-11 00:00:00	\N	\N
2016	11	SANTA EFIGÊNIA DE MINAS	2010-03-11 00:00:00	\N	\N
2017	11	SANTA FÉ DE MINAS	2010-03-11 00:00:00	\N	\N
2018	11	SANTA HELENA DE MINAS	2010-03-11 00:00:00	\N	\N
2019	11	SANTA JULIANA	2010-03-11 00:00:00	\N	\N
2020	11	SANTA LUZIA	2010-03-11 00:00:00	\N	\N
2021	11	SANTA MARGARIDA	2010-03-11 00:00:00	\N	\N
2022	11	SANTA MARIA DE ITABIRA	2010-03-11 00:00:00	\N	\N
2023	11	SANTA MARIA DO SALTO	2010-03-11 00:00:00	\N	\N
2024	11	SANTA MARIA DO SUAÇUI	2010-03-11 00:00:00	\N	\N
2025	11	SANTA RITA DE CALDAS	2010-03-11 00:00:00	\N	\N
2026	11	SANTA RITA DE MINAS	2010-03-11 00:00:00	\N	\N
2027	11	SANTA RITA DO IBITIPOCA	2010-03-11 00:00:00	\N	\N
2028	11	SANTA RITA DO ITUETO	2010-03-11 00:00:00	\N	\N
2029	11	SANTA RITA DO JACUTINGA	2010-03-11 00:00:00	\N	\N
2030	11	SANTA RITA DO SAPUCAÍ	2010-03-11 00:00:00	\N	\N
2031	11	SANTA ROSA DA SERRA	2010-03-11 00:00:00	\N	\N
2032	11	SANTA VITÓRIA	2010-03-11 00:00:00	\N	\N
2033	11	SANTANA DA VARGEM	2010-03-11 00:00:00	\N	\N
2034	11	SANTANA DE CATAGUASES	2010-03-11 00:00:00	\N	\N
2035	11	SANTANA DE PIRAPAMA	2010-03-11 00:00:00	\N	\N
2036	11	SANTANA DO DESERTO	2010-03-11 00:00:00	\N	\N
2037	11	SANTANA DO GARAMBÉU	2010-03-11 00:00:00	\N	\N
2038	11	SANTANA DO JACARÉ	2010-03-11 00:00:00	\N	\N
2039	11	SANTANA DO MANHUAÇU	2010-03-11 00:00:00	\N	\N
2040	11	SANTANA DO PARAÍSO	2010-03-11 00:00:00	\N	\N
2041	11	SANTANA DO RIACHO	2010-03-11 00:00:00	\N	\N
2042	11	SANTANA DOS MONTES	2010-03-11 00:00:00	\N	\N
2043	11	SANTO ANTÔNIO DO AMPARO	2010-03-11 00:00:00	\N	\N
2044	11	SANTO ANTÔNIO DO AVENTUREIRO	2010-03-11 00:00:00	\N	\N
2045	11	SANTO ANTÔNIO DO GRAMA	2010-03-11 00:00:00	\N	\N
2046	11	SANTO ANTÔNIO DO ITAMBÉ	2010-03-11 00:00:00	\N	\N
2047	11	SANTO ANTÔNIO DO JACINTO	2010-03-11 00:00:00	\N	\N
2048	11	SANTO ANTÔNIO DO MONTE	2010-03-11 00:00:00	\N	\N
2049	11	SANTO ANTÔNIO DO RETIRO	2010-03-11 00:00:00	\N	\N
2050	11	SANTO ANTÔNIO DO RIO ABAIXO	2010-03-11 00:00:00	\N	\N
2051	11	SANTO HIPÓLITO	2010-03-11 00:00:00	\N	\N
2052	11	SANTOS DUMONT	2010-03-11 00:00:00	\N	\N
2053	11	SÃO BENTO ABADE	2010-03-11 00:00:00	\N	\N
2054	11	SÃO BRÁS DO SUAÇUÍ	2010-03-11 00:00:00	\N	\N
2055	11	SÃO DOMINGOS DAS DORES	2010-03-11 00:00:00	\N	\N
2056	11	SÃO DOMINGOS DO PRATA	2010-03-11 00:00:00	\N	\N
2057	11	SÃO FÉLIX DE MINAS	2010-03-11 00:00:00	\N	\N
2058	11	SÃO FRANCISCO	2010-03-11 00:00:00	\N	\N
2059	11	SÃO FRANCISCO DE PAULA	2010-03-11 00:00:00	\N	\N
2060	11	SÃO FRANCISCO DE SALES	2010-03-11 00:00:00	\N	\N
2061	11	SÃO FRANCISCO DO GLÓRIA	2010-03-11 00:00:00	\N	\N
2062	11	SÃO GERALDO	2010-03-11 00:00:00	\N	\N
2063	11	SÃO GERALDO DA PIEDADE	2010-03-11 00:00:00	\N	\N
2064	11	SÃO GERALDO DO BAIXIO	2010-03-11 00:00:00	\N	\N
2065	11	SÃO GONÇALO DO ABAETÉ	2010-03-11 00:00:00	\N	\N
2066	11	SÃO GONÇALO DO PARÁ	2010-03-11 00:00:00	\N	\N
2067	11	SÃO GONÇALO DO RIO ABAIXO	2010-03-11 00:00:00	\N	\N
2068	11	SÃO GONÇALO DO RIO PRETO	2010-03-11 00:00:00	\N	\N
2069	11	SÃO GONÇALO DO SAPUCAÍ	2010-03-11 00:00:00	\N	\N
2070	11	SÃO GOTARDO	2010-03-11 00:00:00	\N	\N
2071	11	SÃO JOÃO BATISTA DO GLÓRIA	2010-03-11 00:00:00	\N	\N
2072	11	SÃO JOÃO DA LAGOA	2010-03-11 00:00:00	\N	\N
2073	11	SÃO JOÃO DA MATA	2010-03-11 00:00:00	\N	\N
2074	11	SÃO JOÃO DA PONTE	2010-03-11 00:00:00	\N	\N
2075	11	SÃO JOÃO DAS MISSÕES	2010-03-11 00:00:00	\N	\N
2076	11	SÃO JOÃO DEL REI	2010-03-11 00:00:00	\N	\N
2077	11	SÃO JOÃO DO MANHUAÇU	2010-03-11 00:00:00	\N	\N
2078	11	SÃO JOÃO DO MANTENINHA	2010-03-11 00:00:00	\N	\N
2079	11	SÃO JOÃO DO ORIENTE	2010-03-11 00:00:00	\N	\N
2080	11	SÃO JOÃO DO PACUÍ	2010-03-11 00:00:00	\N	\N
2081	11	SÃO JOÃO DO PARAÍSO	2010-03-11 00:00:00	\N	\N
2082	11	SÃO JOÃO EVANGELISTA	2010-03-11 00:00:00	\N	\N
2083	11	SÃO JOÃO NEPOMUCENO	2010-03-11 00:00:00	\N	\N
2084	11	SÃO JOAQUIM DE BICAS	2010-03-11 00:00:00	\N	\N
2085	11	SÃO JOSÉ DA BARRA	2010-03-11 00:00:00	\N	\N
2086	11	SÃO JOSÉ DA LAPA	2010-03-11 00:00:00	\N	\N
2087	11	SÃO JOSÉ DA SAFIRA	2010-03-11 00:00:00	\N	\N
2088	11	SÃO JOSÉ DA VARGINHA	2010-03-11 00:00:00	\N	\N
2089	11	SÃO JOSÉ DO ALEGRE	2010-03-11 00:00:00	\N	\N
2090	11	SÃO JOSÉ DO DIVINO	2010-03-11 00:00:00	\N	\N
2091	11	SÃO JOSÉ DO GOIABAL	2010-03-11 00:00:00	\N	\N
2092	11	SÃO JOSÉ DO JACURI	2010-03-11 00:00:00	\N	\N
2093	11	SÃO JOSÉ DO MANTIMENTO	2010-03-11 00:00:00	\N	\N
2094	11	SÃO LOURENÇO	2010-03-11 00:00:00	\N	\N
2095	11	SÃO MIGUEL DO ANTA	2010-03-11 00:00:00	\N	\N
2096	11	SÃO PEDRO DA UNIÃO	2010-03-11 00:00:00	\N	\N
2097	11	SÃO PEDRO DO SUAÇUI	2010-03-11 00:00:00	\N	\N
2098	11	SÃO PEDRO DOS FERROS	2010-03-11 00:00:00	\N	\N
2099	11	SÃO ROMÃO	2010-03-11 00:00:00	\N	\N
2100	11	SÃO ROQUE DE MINAS	2010-03-11 00:00:00	\N	\N
2101	11	SÃO SEBASTIÃO DA BELA VISTA	2010-03-11 00:00:00	\N	\N
2102	11	SÃO SEBASTIÃO DA VARGEM ALEGRE	2010-03-11 00:00:00	\N	\N
2103	11	SÃO SEBASTIÃO DO ANTA	2010-03-11 00:00:00	\N	\N
2104	11	SÃO SEBASTIÃO DO MARANHÃO	2010-03-11 00:00:00	\N	\N
2105	11	SÃO SEBASTIÃO DO OESTE	2010-03-11 00:00:00	\N	\N
2106	11	SÃO SEBASTIÃO DO PARAÍSO	2010-03-11 00:00:00	\N	\N
2107	11	SÃO SEBASTIÃO DO RIO PRETO	2010-03-11 00:00:00	\N	\N
2108	11	SÃO SEBASTIÃO DO RIO VERDE	2010-03-11 00:00:00	\N	\N
2109	11	SÃO TIAGO	2010-03-11 00:00:00	\N	\N
2110	11	SÃO TOMÁS DE AQUINO	2010-03-11 00:00:00	\N	\N
2111	11	SÃO TOMÉ DAS LETRAS	2010-03-11 00:00:00	\N	\N
2112	11	SÃO VICENTE DE MINAS	2010-03-11 00:00:00	\N	\N
2113	11	SAPUCAÍ-MIRIM	2010-03-11 00:00:00	\N	\N
2114	11	SARDOA	2010-03-11 00:00:00	\N	\N
2115	11	SARZEDO	2010-03-11 00:00:00	\N	\N
2116	11	SEM PEIXE	2010-03-11 00:00:00	\N	\N
2117	11	SENADOR AMARAL	2010-03-11 00:00:00	\N	\N
2118	11	SENADOR CORTES	2010-03-11 00:00:00	\N	\N
2119	11	SENADOR FIRMINO	2010-03-11 00:00:00	\N	\N
2120	11	SENADOR JOSÉ BENTO	2010-03-11 00:00:00	\N	\N
2121	11	SENADOR MODESTINO GONÇALVES	2010-03-11 00:00:00	\N	\N
2122	11	SENHORA DE OLIVEIRA	2010-03-11 00:00:00	\N	\N
2123	11	SENHORA DO PORTO	2010-03-11 00:00:00	\N	\N
2124	11	SENHORA DOS REMÉDIOS	2010-03-11 00:00:00	\N	\N
2125	11	SERICITA	2010-03-11 00:00:00	\N	\N
2126	11	SERITINGA	2010-03-11 00:00:00	\N	\N
2127	11	SERRA AZUL DE MINAS	2010-03-11 00:00:00	\N	\N
2128	11	SERRA DA SAUDADE	2010-03-11 00:00:00	\N	\N
2129	11	SERRA DO SALITRE	2010-03-11 00:00:00	\N	\N
2130	11	SERRA DOS AIMORÉS	2010-03-11 00:00:00	\N	\N
2131	11	SERRÂNIA	2010-03-11 00:00:00	\N	\N
2132	11	SERRANÓPOLIS DE MINAS	2010-03-11 00:00:00	\N	\N
2133	11	SERRANOS	2010-03-11 00:00:00	\N	\N
2134	11	SERRO	2010-03-11 00:00:00	\N	\N
2135	11	SETE LAGOAS	2010-03-11 00:00:00	\N	\N
2136	11	SETUBINHA	2010-03-11 00:00:00	\N	\N
2137	11	SILVEIRÂNIA	2010-03-11 00:00:00	\N	\N
2138	11	SILVIANÓPOLIS	2010-03-11 00:00:00	\N	\N
2139	11	SIMÃO PEREIRA	2010-03-11 00:00:00	\N	\N
2140	11	SIMONÉSIA	2010-03-11 00:00:00	\N	\N
2141	11	SOBRÁLIA	2010-03-11 00:00:00	\N	\N
2142	11	SOLEDADE DE MINAS	2010-03-11 00:00:00	\N	\N
2143	11	TABULEIRO	2010-03-11 00:00:00	\N	\N
2144	11	TAIOBEIRAS	2010-03-11 00:00:00	\N	\N
2145	11	TAPARUBA	2010-03-11 00:00:00	\N	\N
2146	11	TAPIRA	2010-03-11 00:00:00	\N	\N
2147	11	TAPIRAÍ	2010-03-11 00:00:00	\N	\N
2148	11	TAQUARAÇU DE MINAS	2010-03-11 00:00:00	\N	\N
2149	11	TARUMIRIM	2010-03-11 00:00:00	\N	\N
2150	11	TEIXEIRAS	2010-03-11 00:00:00	\N	\N
2151	11	TEÓFILO OTONI	2010-03-11 00:00:00	\N	\N
2152	11	TIMÓTEO	2010-03-11 00:00:00	\N	\N
2153	11	TIRADENTES	2010-03-11 00:00:00	\N	\N
2154	11	TIROS	2010-03-11 00:00:00	\N	\N
2155	11	TOCANTINS	2010-03-11 00:00:00	\N	\N
2156	11	TOCOS DO MOJI	2010-03-11 00:00:00	\N	\N
2157	11	TOLEDO	2010-03-11 00:00:00	\N	\N
2158	11	TOMBOS	2010-03-11 00:00:00	\N	\N
2159	11	TRÊS CORAÇÕES	2010-03-11 00:00:00	\N	\N
2160	11	TRÊS MARIAS	2010-03-11 00:00:00	\N	\N
2161	11	TRÊS PONTAS	2010-03-11 00:00:00	\N	\N
2162	11	TUMIRITINGA	2010-03-11 00:00:00	\N	\N
2163	11	TUPACIGUARA	2010-03-11 00:00:00	\N	\N
2164	11	TURMALINA	2010-03-11 00:00:00	\N	\N
2165	11	TURVOLÂNDIA	2010-03-11 00:00:00	\N	\N
2166	11	UBÁ	2010-03-11 00:00:00	\N	\N
2167	11	UBAÍ	2010-03-11 00:00:00	\N	\N
2168	11	UBAPORANGA	2010-03-11 00:00:00	\N	\N
2169	11	UBERABA	2010-03-11 00:00:00	\N	\N
2170	11	UBERLÂNDIA	2010-03-11 00:00:00	\N	\N
2171	11	UMBURATIBA	2010-03-11 00:00:00	\N	\N
2172	11	UNAÍ	2010-03-11 00:00:00	\N	\N
2173	11	UNIÃO DE MINAS	2010-03-11 00:00:00	\N	\N
2174	11	URUANA DE MINAS	2010-03-11 00:00:00	\N	\N
2175	11	URUCÂNIA	2010-03-11 00:00:00	\N	\N
2176	11	URUCUIA	2010-03-11 00:00:00	\N	\N
2177	11	VARGEM ALEGRE	2010-03-11 00:00:00	\N	\N
2178	11	VARGEM BONITA	2010-03-11 00:00:00	\N	\N
2179	11	VARGEM GRANDE DO RIO PARDO	2010-03-11 00:00:00	\N	\N
2180	11	VARGINHA	2010-03-11 00:00:00	\N	\N
2181	11	VARJÃO DE MINAS	2010-03-11 00:00:00	\N	\N
2182	11	VÁRZEA DA PALMA	2010-03-11 00:00:00	\N	\N
2183	11	VARZELÂNDIA	2010-03-11 00:00:00	\N	\N
2184	11	VAZANTE	2010-03-11 00:00:00	\N	\N
2185	11	VERDELÂNDIA	2010-03-11 00:00:00	\N	\N
2186	11	VEREDINHA	2010-03-11 00:00:00	\N	\N
2187	11	VERÍSSIMO	2010-03-11 00:00:00	\N	\N
2188	11	VERMELHO NOVO	2010-03-11 00:00:00	\N	\N
2189	11	VESPASIANO	2010-03-11 00:00:00	\N	\N
2190	11	VIÇOSA	2010-03-11 00:00:00	\N	\N
2191	11	VIEIRAS	2010-03-11 00:00:00	\N	\N
2192	11	VIRGEM DA LAPA	2010-03-11 00:00:00	\N	\N
2193	11	VIRGÍNIA	2010-03-11 00:00:00	\N	\N
2194	11	VIRGINÓPOLIS	2010-03-11 00:00:00	\N	\N
2195	11	VIRGOLÂNDIA	2010-03-11 00:00:00	\N	\N
2196	11	VISCONDE DO RIO BRANCO	2010-03-11 00:00:00	\N	\N
2197	11	VOLTA GRANDE	2010-03-11 00:00:00	\N	\N
2198	11	WENCESLAU BRAZ	2010-03-11 00:00:00	\N	\N
2199	12	ÁGUA CLARA	2010-03-11 00:00:00	\N	\N
2200	12	ALCINÓPOLIS	2010-03-11 00:00:00	\N	\N
2201	12	AMAMBAÍ	2010-03-11 00:00:00	\N	\N
2202	12	ANASTÁCIO	2010-03-11 00:00:00	\N	\N
2203	12	ANAURILÂNDIA	2010-03-11 00:00:00	\N	\N
2204	12	ANGÉLICA	2010-03-11 00:00:00	\N	\N
2205	12	ANTÔNIO JOÃO	2010-03-11 00:00:00	\N	\N
2206	12	APARECIDA DO TABOADO	2010-03-11 00:00:00	\N	\N
2207	12	AQUIDAUANA	2010-03-11 00:00:00	\N	\N
2208	12	ARAL MOREIRA	2010-03-11 00:00:00	\N	\N
2209	12	BANDEIRANTES	2010-03-11 00:00:00	\N	\N
2210	12	BATAGUASSU	2010-03-11 00:00:00	\N	\N
2211	12	BATAYPORÃ	2010-03-11 00:00:00	\N	\N
2212	12	BELA VISTA	2010-03-11 00:00:00	\N	\N
2213	12	BODOQUENA	2010-03-11 00:00:00	\N	\N
2214	12	BONITO	2010-03-11 00:00:00	\N	\N
2215	12	BRASILÂNDIA	2010-03-11 00:00:00	\N	\N
2216	12	CAARAPÓ	2010-03-11 00:00:00	\N	\N
2217	12	CAMAPUÃ	2010-03-11 00:00:00	\N	\N
2218	12	CAMPO GRANDE	2010-03-11 00:00:00	\N	\N
2219	12	CARACOL	2010-03-11 00:00:00	\N	\N
2220	12	CASSILÂNDIA	2010-03-11 00:00:00	\N	\N
2221	12	CHAPADÃO DO SUL	2010-03-11 00:00:00	\N	\N
2222	12	CORGUINHO	2010-03-11 00:00:00	\N	\N
2223	12	CORONEL SAPUCAIA	2010-03-11 00:00:00	\N	\N
2224	12	CORUMBÁ	2010-03-11 00:00:00	\N	\N
2225	12	COSTA RICA	2010-03-11 00:00:00	\N	\N
2226	12	COXIM	2010-03-11 00:00:00	\N	\N
2227	12	DEADÁPOLIS	2010-03-11 00:00:00	\N	\N
2228	12	DOIS IRMÃOS DO BURITI	2010-03-11 00:00:00	\N	\N
2229	12	DOURADINA	2010-03-11 00:00:00	\N	\N
2230	12	DOURADOS	2010-03-11 00:00:00	\N	\N
2231	12	ELDORADO	2010-03-11 00:00:00	\N	\N
2232	12	FÁTIMA DO SUL	2010-03-11 00:00:00	\N	\N
2233	12	FIGUEIRÃO	2010-03-11 00:00:00	\N	\N
2234	12	GLÓRIA DE DOURADOS	2010-03-11 00:00:00	\N	\N
2235	12	GUIA LOPES DA LAGUNA	2010-03-11 00:00:00	\N	\N
2236	12	IGUATEMI	2010-03-11 00:00:00	\N	\N
2237	12	INOCÊNCIA	2010-03-11 00:00:00	\N	\N
2238	12	ITAPORÃ	2010-03-11 00:00:00	\N	\N
2239	12	ITAQUIRAÍ	2010-03-11 00:00:00	\N	\N
2240	12	IVINHEMA	2010-03-11 00:00:00	\N	\N
2241	12	JAPORÃ	2010-03-11 00:00:00	\N	\N
2242	12	JARAGUARI	2010-03-11 00:00:00	\N	\N
2243	12	JARDIM	2010-03-11 00:00:00	\N	\N
2244	12	JATEÍ	2010-03-11 00:00:00	\N	\N
2245	12	JUTI	2010-03-11 00:00:00	\N	\N
2246	12	LADÁRIO	2010-03-11 00:00:00	\N	\N
2247	12	LAGUNA CARAPÃ	2010-03-11 00:00:00	\N	\N
2248	12	MARACAJU	2010-03-11 00:00:00	\N	\N
2249	12	MIRANDA	2010-03-11 00:00:00	\N	\N
2250	12	MUNDO NOVO	2010-03-11 00:00:00	\N	\N
2251	12	NAVIRAÍ	2010-03-11 00:00:00	\N	\N
2252	12	NIOAQUE	2010-03-11 00:00:00	\N	\N
2253	12	NOVA ALVORADA DO SUL	2010-03-11 00:00:00	\N	\N
2254	12	NOVA ANDRADINA	2010-03-11 00:00:00	\N	\N
2255	12	NOVO HORIZONTE DO SUL	2010-03-11 00:00:00	\N	\N
2256	12	PARANAÍBA	2010-03-11 00:00:00	\N	\N
2257	12	PARANHOS	2010-03-11 00:00:00	\N	\N
2258	12	PEDRO GOMES	2010-03-11 00:00:00	\N	\N
2259	12	PONTA PORÃ	2010-03-11 00:00:00	\N	\N
2260	12	PORTO MURTINHO	2010-03-11 00:00:00	\N	\N
2261	12	RIBAS DO RIO PARDO	2010-03-11 00:00:00	\N	\N
2262	12	RIO BRILHANTE	2010-03-11 00:00:00	\N	\N
2263	12	RIO NEGRO	2010-03-11 00:00:00	\N	\N
2264	12	RIO VERDE DE MATO GROSSO	2010-03-11 00:00:00	\N	\N
2265	12	ROCHEDO	2010-03-11 00:00:00	\N	\N
2266	12	SANTA RITA DO PARDO	2010-03-11 00:00:00	\N	\N
2267	12	SÃO GABRIEL DO OESTE	2010-03-11 00:00:00	\N	\N
2268	12	SELVÍRIA	2010-03-11 00:00:00	\N	\N
2269	12	SETE QUEDAS	2010-03-11 00:00:00	\N	\N
2270	12	SIDROLÂNDIA	2010-03-11 00:00:00	\N	\N
2271	12	SONORA	2010-03-11 00:00:00	\N	\N
2272	12	TACURU	2010-03-11 00:00:00	\N	\N
2273	12	TAQUARUSSU	2010-03-11 00:00:00	\N	\N
2274	12	TERENOS	2010-03-11 00:00:00	\N	\N
2275	12	TRÊS LAGOAS	2010-03-11 00:00:00	\N	\N
2276	12	VICENTINA	2010-03-11 00:00:00	\N	\N
2277	13	ACORIZAL	2010-03-11 00:00:00	\N	\N
2278	13	ÁGUA BOA	2010-03-11 00:00:00	\N	\N
2279	13	ALTA FLORESTA	2010-03-11 00:00:00	\N	\N
2280	13	ALTO ARAGUAIA	2010-03-11 00:00:00	\N	\N
2281	13	ALTO BOA VISTA	2010-03-11 00:00:00	\N	\N
2282	13	ALTO GARÇAS	2010-03-11 00:00:00	\N	\N
2283	13	ALTO PARAGUAI	2010-03-11 00:00:00	\N	\N
2284	13	ALTO TAQUARI	2010-03-11 00:00:00	\N	\N
2285	13	APIACÁS	2010-03-11 00:00:00	\N	\N
2286	13	ARAGUAIANA	2010-03-11 00:00:00	\N	\N
2287	13	ARAGUAINHA	2010-03-11 00:00:00	\N	\N
2288	13	ARAPUTANGA	2010-03-11 00:00:00	\N	\N
2289	13	ARENÁPOLIS	2010-03-11 00:00:00	\N	\N
2290	13	ARIPUANÃ	2010-03-11 00:00:00	\N	\N
2291	13	BARÃO DE MELGAÇO	2010-03-11 00:00:00	\N	\N
2292	13	BARRA DO BUGRES	2010-03-11 00:00:00	\N	\N
2293	13	BARRA DO GARÇAS	2010-03-11 00:00:00	\N	\N
2294	13	BOM JESUS DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
2295	13	BRASNORTE	2010-03-11 00:00:00	\N	\N
2296	13	CÁCERES	2010-03-11 00:00:00	\N	\N
2297	13	CAMPINÁPOLIS	2010-03-11 00:00:00	\N	\N
2298	13	CAMPO NOVO DO PARECIS	2010-03-11 00:00:00	\N	\N
2299	13	CAMPO VERDE	2010-03-11 00:00:00	\N	\N
2300	13	CAMPOS DE JÚLIO	2010-03-11 00:00:00	\N	\N
2301	13	CANABRAVA DO NORTE	2010-03-11 00:00:00	\N	\N
2302	13	CANARANA	2010-03-11 00:00:00	\N	\N
2303	13	CARLINDA	2010-03-11 00:00:00	\N	\N
2304	13	CASTANHEIRA	2010-03-11 00:00:00	\N	\N
2305	13	CHAPADA DOS GUIMARÃES	2010-03-11 00:00:00	\N	\N
2306	13	CLÁUDIA	2010-03-11 00:00:00	\N	\N
2307	13	COCALINHO	2010-03-11 00:00:00	\N	\N
2308	13	COLIDER	2010-03-11 00:00:00	\N	\N
2309	13	COLNIZA	2010-03-11 00:00:00	\N	\N
2310	13	COMODORO	2010-03-11 00:00:00	\N	\N
2311	13	CONFRESA	2010-03-11 00:00:00	\N	\N
2312	13	CONQUISTA D´OESTE	2010-03-11 00:00:00	\N	\N
2313	13	COTRIGUAÇU	2010-03-11 00:00:00	\N	\N
2314	13	CUIABÁ	2010-03-11 00:00:00	\N	\N
2315	13	CURVELÂNDIA	2010-03-11 00:00:00	\N	\N
2316	13	DENISE	2010-03-11 00:00:00	\N	\N
2317	13	DIAMANTINO	2010-03-11 00:00:00	\N	\N
2318	13	DOM AQUINO	2010-03-11 00:00:00	\N	\N
2319	13	FELIZ NATAL	2010-03-11 00:00:00	\N	\N
2320	13	FIGUEIRÓPOLIS D OESTE	2010-03-11 00:00:00	\N	\N
2321	13	GAÚCHA DO NORTE	2010-03-11 00:00:00	\N	\N
2322	13	GENERAL CARNEIRO	2010-03-11 00:00:00	\N	\N
2323	13	GLÓRIA D OESTE	2010-03-11 00:00:00	\N	\N
2324	13	GUARANTÃ DO NORTE	2010-03-11 00:00:00	\N	\N
2325	13	GUIRATINGA	2010-03-11 00:00:00	\N	\N
2326	13	INDIAVAÍ	2010-03-11 00:00:00	\N	\N
2327	13	IPIRANGA DO NORTE	2010-03-11 00:00:00	\N	\N
2328	13	ITANHANGÁ	2010-03-11 00:00:00	\N	\N
2329	13	ITAUBA	2010-03-11 00:00:00	\N	\N
2330	13	ITIQUIRA	2010-03-11 00:00:00	\N	\N
2331	13	JACIARA	2010-03-11 00:00:00	\N	\N
2332	13	JANGADA	2010-03-11 00:00:00	\N	\N
2333	13	JAURU	2010-03-11 00:00:00	\N	\N
2334	13	JUARA	2010-03-11 00:00:00	\N	\N
2335	13	JUÍNA	2010-03-11 00:00:00	\N	\N
2336	13	JURUENA	2010-03-11 00:00:00	\N	\N
2337	13	JUSCIMEIRA	2010-03-11 00:00:00	\N	\N
2338	13	LAMBARI D OESTE	2010-03-11 00:00:00	\N	\N
2339	13	LUCAS DO RIO VERDE	2010-03-11 00:00:00	\N	\N
2340	13	LUCIARA	2010-03-11 00:00:00	\N	\N
2341	13	MARCELÂNDIA	2010-03-11 00:00:00	\N	\N
2342	13	MATUPÁ	2010-03-11 00:00:00	\N	\N
2343	13	MIRASSOL D OESTE	2010-03-11 00:00:00	\N	\N
2344	13	NOBRES	2010-03-11 00:00:00	\N	\N
2345	13	NORTELÂNDIA	2010-03-11 00:00:00	\N	\N
2346	13	NOSSA SENHORA DO LIVRAMENTO	2010-03-11 00:00:00	\N	\N
2347	13	NOVA BANDEIRANTES	2010-03-11 00:00:00	\N	\N
2348	13	NOVA BRASILÂNDIA	2010-03-11 00:00:00	\N	\N
2349	13	NOVA CANAÃ DO NORTE	2010-03-11 00:00:00	\N	\N
2350	13	NOVA GUARITA	2010-03-11 00:00:00	\N	\N
2351	13	NOVA LACERDA	2010-03-11 00:00:00	\N	\N
2352	13	NOVA MARILÂNDIA	2010-03-11 00:00:00	\N	\N
2353	13	NOVA MARINGÁ	2010-03-11 00:00:00	\N	\N
2354	13	NOVA MONTE VERDE	2010-03-11 00:00:00	\N	\N
2355	13	NOVA MUTUM	2010-03-11 00:00:00	\N	\N
2356	13	NOVA NAZARÉ	2010-03-11 00:00:00	\N	\N
2357	13	NOVA OLÍMPIA	2010-03-11 00:00:00	\N	\N
2358	13	NOVA SANTA HELENA	2010-03-11 00:00:00	\N	\N
2359	13	NOVA UBIRATÃ	2010-03-11 00:00:00	\N	\N
2360	13	NOVA XAVANTINA	2010-03-11 00:00:00	\N	\N
2361	13	NOVO HORIZONTE DO NORTE	2010-03-11 00:00:00	\N	\N
2362	13	NOVO MUNDO	2010-03-11 00:00:00	\N	\N
2363	13	NOVO SANTO ANTÔNIO	2010-03-11 00:00:00	\N	\N
2364	13	NOVO SÃO JOAQUIM	2010-03-11 00:00:00	\N	\N
2365	13	PARANAÍTA	2010-03-11 00:00:00	\N	\N
2366	13	PARANATINGA	2010-03-11 00:00:00	\N	\N
2367	13	PEDRA PRETA	2010-03-11 00:00:00	\N	\N
2368	13	PEIXOTO DE AZEVEDO	2010-03-11 00:00:00	\N	\N
2369	13	PLANALTO DA SERRA	2010-03-11 00:00:00	\N	\N
2370	13	POCONÉ	2010-03-11 00:00:00	\N	\N
2371	13	PONTAL DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
2372	13	PONTE BRANCA	2010-03-11 00:00:00	\N	\N
2373	13	PONTES E LACERDA	2010-03-11 00:00:00	\N	\N
2374	13	PORTO ALEGRE DO NORTE	2010-03-11 00:00:00	\N	\N
2375	13	PORTO DOS GAÚCHOS	2010-03-11 00:00:00	\N	\N
2376	13	PORTO ESPERIDIÃO	2010-03-11 00:00:00	\N	\N
2377	13	PORTO ESTRELA	2010-03-11 00:00:00	\N	\N
2378	13	POXOREO	2010-03-11 00:00:00	\N	\N
2379	13	PRIMAVERA DO LESTE	2010-03-11 00:00:00	\N	\N
2380	13	QUERÊNCIA	2010-03-11 00:00:00	\N	\N
2381	13	RESERVA DO CABAÇAL	2010-03-11 00:00:00	\N	\N
2382	13	RIBEIRÃO CASCALHEIRA	2010-03-11 00:00:00	\N	\N
2383	13	RIBEIRÃOZINHO	2010-03-11 00:00:00	\N	\N
2384	13	RIO BRANCO	2010-03-11 00:00:00	\N	\N
2385	13	RONDOLÂNDIA	2010-03-11 00:00:00	\N	\N
2386	13	RONDONÓPOLIS	2010-03-11 00:00:00	\N	\N
2387	13	ROSÁRIO DO OESTE	2010-03-11 00:00:00	\N	\N
2388	13	SALTO DO CÉU	2010-03-11 00:00:00	\N	\N
2389	13	SANTA  RITA DO TRIVELATO	2010-03-11 00:00:00	\N	\N
2390	13	SANTA CARMEM	2010-03-11 00:00:00	\N	\N
2391	13	SANTA CRUZ DO XINGU	2010-03-11 00:00:00	\N	\N
2392	13	SANTA TEREZINHA	2010-03-11 00:00:00	\N	\N
2393	13	SANTO AFONSO	2010-03-11 00:00:00	\N	\N
2394	13	SANTO ANTONIO DO LESTE	2010-03-11 00:00:00	\N	\N
2395	13	SANTO ANTÔNIO DO LEVERGER	2010-03-11 00:00:00	\N	\N
2396	13	SÃO FÉLIX DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
2397	13	SÃO JOSÉ DO POVO	2010-03-11 00:00:00	\N	\N
2398	13	SÃO JOSÉ DO RIO CLARO	2010-03-11 00:00:00	\N	\N
2399	13	SÃO JOSÉ DO XINGU	2010-03-11 00:00:00	\N	\N
2400	13	SÃO JOSÉ DOS QUATRO MARCOS	2010-03-11 00:00:00	\N	\N
2401	13	SÃO PEDRO DA CIPA	2010-03-11 00:00:00	\N	\N
2402	13	SAPEZAL	2010-03-11 00:00:00	\N	\N
2403	13	SERRA NOVA DOURADA	2010-03-11 00:00:00	\N	\N
2404	13	SINOP	2010-03-11 00:00:00	\N	\N
2405	13	SORRISO	2010-03-11 00:00:00	\N	\N
2406	13	TABAPORÃ	2010-03-11 00:00:00	\N	\N
2407	13	TANGARÁ DA SERRA	2010-03-11 00:00:00	\N	\N
2408	13	TAPURAH	2010-03-11 00:00:00	\N	\N
2409	13	TERRA NOVA DO NORTE	2010-03-11 00:00:00	\N	\N
2410	13	TESOURO	2010-03-11 00:00:00	\N	\N
2411	13	TORIXORÉU	2010-03-11 00:00:00	\N	\N
2412	13	UNIÃO DO SUL	2010-03-11 00:00:00	\N	\N
2413	13	VALE DE SÃO DOMINGOS	2010-03-11 00:00:00	\N	\N
2414	13	VÁRZEA GRANDE	2010-03-11 00:00:00	\N	\N
2415	13	VERA	2010-03-11 00:00:00	\N	\N
2416	13	VILA BELA DA SANTÍSSIMA TRINDADE	2010-03-11 00:00:00	\N	\N
2417	13	VILA RICA	2010-03-11 00:00:00	\N	\N
2419	14	ABEL FIGUEIREDO	2010-03-11 00:00:00	\N	\N
2420	14	ACARA	2010-03-11 00:00:00	\N	\N
2421	14	AFUA	2010-03-11 00:00:00	\N	\N
2422	14	ÁGUA AZUL DO NORTE	2010-03-11 00:00:00	\N	\N
2423	14	ALENQUER	2010-03-11 00:00:00	\N	\N
2424	14	ALMEIRIM	2010-03-11 00:00:00	\N	\N
2425	14	ALTAMIRA	2010-03-11 00:00:00	\N	\N
2426	14	ANAJÁS	2010-03-11 00:00:00	\N	\N
2427	14	ANANINDEUA	2010-03-11 00:00:00	\N	\N
2428	14	ANAPÚ	2010-03-11 00:00:00	\N	\N
2429	14	AUGUSTO CORREA	2010-03-11 00:00:00	\N	\N
2430	14	AURORA DO PARÁ	2010-03-11 00:00:00	\N	\N
2431	14	AVEIRO	2010-03-11 00:00:00	\N	\N
2432	14	BAGRE	2010-03-11 00:00:00	\N	\N
2433	14	BAIÃO	2010-03-11 00:00:00	\N	\N
2434	14	BANNACH	2010-03-11 00:00:00	\N	\N
2435	14	BARCARENA	2010-03-11 00:00:00	\N	\N
2436	14	BELÉM	2010-03-11 00:00:00	\N	\N
2437	14	BELTERRA	2010-03-11 00:00:00	\N	\N
2438	14	BENEVIDES	2010-03-11 00:00:00	\N	\N
2439	14	BOM JESUS DO TOCANTINS	2010-03-11 00:00:00	\N	\N
2440	14	BONITO	2010-03-11 00:00:00	\N	\N
2441	14	BRAGANÇA	2010-03-11 00:00:00	\N	\N
2442	14	BRASIL NOVO	2010-03-11 00:00:00	\N	\N
2443	14	BREJO GRANDE DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
2444	14	BREU BRANCO	2010-03-11 00:00:00	\N	\N
2445	14	BREVES	2010-03-11 00:00:00	\N	\N
2446	14	BUJARU	2010-03-11 00:00:00	\N	\N
2447	14	CACHOEIRA DO ARARI	2010-03-11 00:00:00	\N	\N
2448	14	CACHOEIRA DO PIRIÁ	2010-03-11 00:00:00	\N	\N
2449	14	CAMETÁ	2010-03-11 00:00:00	\N	\N
2450	14	CANAÃ DOS CARAJÁS	2010-03-11 00:00:00	\N	\N
2451	14	CAPANEMA	2010-03-11 00:00:00	\N	\N
2452	14	CAPITÃO POÇO	2010-03-11 00:00:00	\N	\N
2453	14	CASTANHAL	2010-03-11 00:00:00	\N	\N
2454	14	CHAVES	2010-03-11 00:00:00	\N	\N
2455	14	COLARES	2010-03-11 00:00:00	\N	\N
2456	14	CONCEIÇÃO DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
2457	14	CONCÓRDIA DO PARÁ	2010-03-11 00:00:00	\N	\N
2458	14	CUMARU DO NORTE	2010-03-11 00:00:00	\N	\N
2459	14	CURIONÓPOLIS	2010-03-11 00:00:00	\N	\N
2460	14	CURRALINHO	2010-03-11 00:00:00	\N	\N
2461	14	CURUÁ	2010-03-11 00:00:00	\N	\N
2462	14	CURUÇA	2010-03-11 00:00:00	\N	\N
2463	14	DOM ELISEU	2010-03-11 00:00:00	\N	\N
2464	14	ELDORADO DOS CARAJÁS	2010-03-11 00:00:00	\N	\N
2465	14	FARO	2010-03-11 00:00:00	\N	\N
2466	14	FLORESTA DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
2467	14	GARRAFÃO DO NORTE	2010-03-11 00:00:00	\N	\N
2468	14	GOIANÉSIA DO PARÁ	2010-03-11 00:00:00	\N	\N
2469	14	GURUPA	2010-03-11 00:00:00	\N	\N
2470	14	IGARAPÉ-AÇU	2010-03-11 00:00:00	\N	\N
2471	14	IGARAPÉ-MIRI	2010-03-11 00:00:00	\N	\N
2472	14	INHANGAPI	2010-03-11 00:00:00	\N	\N
2473	14	IPIXUNA DO PARÁ	2010-03-11 00:00:00	\N	\N
2474	14	IRITUIA	2010-03-11 00:00:00	\N	\N
2475	14	ITAITUBA	2010-03-11 00:00:00	\N	\N
2476	14	ITUPIRANGA	2010-03-11 00:00:00	\N	\N
2477	14	JACAREACANGA	2010-03-11 00:00:00	\N	\N
2478	14	JACUNDÁ	2010-03-11 00:00:00	\N	\N
2479	14	JURUTI	2010-03-11 00:00:00	\N	\N
2480	14	LIMOEIRO DO AJURU	2010-03-11 00:00:00	\N	\N
2481	14	MÃE DO RIO	2010-03-11 00:00:00	\N	\N
2482	14	MAGALHÃES BARATA	2010-03-11 00:00:00	\N	\N
2483	14	MARABÁ	2010-03-11 00:00:00	\N	\N
2484	14	MARACANÃ	2010-03-11 00:00:00	\N	\N
2485	14	MARAPANIM	2010-03-11 00:00:00	\N	\N
2486	14	MARITUBA	2010-03-11 00:00:00	\N	\N
2487	14	MEDICILÂNDIA	2010-03-11 00:00:00	\N	\N
2488	14	MELGAÇO	2010-03-11 00:00:00	\N	\N
2489	14	MOCAJUBA	2010-03-11 00:00:00	\N	\N
2490	14	MOJU	2010-03-11 00:00:00	\N	\N
2491	14	MONTE ALEGRE	2010-03-11 00:00:00	\N	\N
2492	14	MUANA	2010-03-11 00:00:00	\N	\N
2493	14	NOVA ESPERANÇA DO PIRIÁ	2010-03-11 00:00:00	\N	\N
2494	14	NOVA IPIXUNA	2010-03-11 00:00:00	\N	\N
2495	14	NOVA TIMBOTEUA	2010-03-11 00:00:00	\N	\N
2496	14	NOVO PROGRESSO	2010-03-11 00:00:00	\N	\N
2497	14	NOVO REPARTIMENTO	2010-03-11 00:00:00	\N	\N
2498	14	ÓBIDOS	2010-03-11 00:00:00	\N	\N
2499	14	OEIRAS DO PARÁ	2010-03-11 00:00:00	\N	\N
2500	14	ORIXIMINA	2010-03-11 00:00:00	\N	\N
2501	14	OUREM	2010-03-11 00:00:00	\N	\N
2502	14	OURILÂNDIA DO NORTE	2010-03-11 00:00:00	\N	\N
2503	14	PACAJÁ	2010-03-11 00:00:00	\N	\N
2504	14	PALESTINA DO PARÁ	2010-03-11 00:00:00	\N	\N
2505	14	PARAGOMINAS	2010-03-11 00:00:00	\N	\N
2506	14	PARAUAPEBAS	2010-03-11 00:00:00	\N	\N
2507	14	PAU D ARCO	2010-03-11 00:00:00	\N	\N
2508	14	PEIXE-BOI	2010-03-11 00:00:00	\N	\N
2509	14	PIÇARRA	2010-03-11 00:00:00	\N	\N
2510	14	PLACAS	2010-03-11 00:00:00	\N	\N
2511	14	PONTA DE PEDRAS	2010-03-11 00:00:00	\N	\N
2512	14	PORTEL	2010-03-11 00:00:00	\N	\N
2513	14	PORTO DE MOZ	2010-03-11 00:00:00	\N	\N
2514	14	PRAINHA	2010-03-11 00:00:00	\N	\N
2515	14	PRIMAVERA	2010-03-11 00:00:00	\N	\N
2516	14	QUATIPURÚ	2010-03-11 00:00:00	\N	\N
2517	14	REDENÇÃO	2010-03-11 00:00:00	\N	\N
2518	14	RIO MARIA	2010-03-11 00:00:00	\N	\N
2519	14	RONDON DO PARÁ	2010-03-11 00:00:00	\N	\N
2520	14	RURÓPOLIS	2010-03-11 00:00:00	\N	\N
2521	14	SALINÓPLIS	2010-03-11 00:00:00	\N	\N
2522	14	SALVATERRA	2010-03-11 00:00:00	\N	\N
2523	14	SANTA BÁRBARA DO PARÁ	2010-03-11 00:00:00	\N	\N
2524	14	SANTA CRUZ DO ARARI	2010-03-11 00:00:00	\N	\N
2525	14	SANTA ISABEL DO PARÁ	2010-03-11 00:00:00	\N	\N
2526	14	SANTA LUZIA DO PARÁ	2010-03-11 00:00:00	\N	\N
2527	14	SANTA MARIA DAS BARREIRAS	2010-03-11 00:00:00	\N	\N
2528	14	SANTA MARIA DO PARÁ	2010-03-11 00:00:00	\N	\N
2529	14	SANTANA DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
2530	14	SANTARÉM	2010-03-11 00:00:00	\N	\N
2531	14	SANTARÉM NOVO	2010-03-11 00:00:00	\N	\N
2532	14	SANTO ANTÔNIO DO TAUÁ	2010-03-11 00:00:00	\N	\N
2533	14	SÃO CAETANO DE ODIVELAS	2010-03-11 00:00:00	\N	\N
2534	14	SÃO DOMINGOS DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
2535	14	SÃO DOMINGOS DO CAPIM	2010-03-11 00:00:00	\N	\N
2536	14	SÃO FÉLIX DO XINGU	2010-03-11 00:00:00	\N	\N
2537	14	SÃO FRANCISCO DO PARÁ	2010-03-11 00:00:00	\N	\N
2538	14	SÃO GERALDO DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
2539	14	SÃO JOÃO DA PONTA	2010-03-11 00:00:00	\N	\N
2540	14	SÃO JOÃO DE PIRABAS	2010-03-11 00:00:00	\N	\N
2541	14	SÃO JOÃO DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
2542	14	SÃO MIGUEL DO GUAMA	2010-03-11 00:00:00	\N	\N
2543	14	SÃO SEBASTIÃO DA BOA VISTA	2010-03-11 00:00:00	\N	\N
2544	14	SAPUCAIA	2010-03-11 00:00:00	\N	\N
2545	14	SENADOR JOSÉ PORFÍRIO	2010-03-11 00:00:00	\N	\N
2546	14	SOURE	2010-03-11 00:00:00	\N	\N
2547	14	TAILÂNDIA	2010-03-11 00:00:00	\N	\N
2548	14	TERRA ALTA	2010-03-11 00:00:00	\N	\N
2549	14	TERRA SANTA	2010-03-11 00:00:00	\N	\N
2550	14	TOME-AÇU	2010-03-11 00:00:00	\N	\N
2551	14	TRACUATEUA	2010-03-11 00:00:00	\N	\N
2552	14	TRAIRÃO	2010-03-11 00:00:00	\N	\N
2553	14	TUCUMÃ	2010-03-11 00:00:00	\N	\N
2554	14	TUCURUÍ	2010-03-11 00:00:00	\N	\N
2555	14	ULIANÓPOLIS	2010-03-11 00:00:00	\N	\N
2556	14	URUARA	2010-03-11 00:00:00	\N	\N
2557	14	VIGIA	2010-03-11 00:00:00	\N	\N
2558	14	VISEU	2010-03-11 00:00:00	\N	\N
2559	14	VITÓRIA DO XINGU	2010-03-11 00:00:00	\N	\N
2560	14	XINGUARA	2010-03-11 00:00:00	\N	\N
2561	15	ÁGUA BRANCA	2010-03-11 00:00:00	\N	\N
2562	15	AGUIAR	2010-03-11 00:00:00	\N	\N
2563	15	ALAGOA GRANDE	2010-03-11 00:00:00	\N	\N
2564	15	ALAGOA NOVA	2010-03-11 00:00:00	\N	\N
2565	15	ALAGOINHA	2010-03-11 00:00:00	\N	\N
2566	15	ALCANTIL	2010-03-11 00:00:00	\N	\N
2567	15	ALGODÃO DE JANDAÍRA	2010-03-11 00:00:00	\N	\N
2568	15	ALHANDRA	2010-03-11 00:00:00	\N	\N
2569	15	AMPARO	2010-03-11 00:00:00	\N	\N
2570	15	APARECIDA	2010-03-11 00:00:00	\N	\N
2571	15	ARAÇAGI	2010-03-11 00:00:00	\N	\N
2572	15	ARARA	2010-03-11 00:00:00	\N	\N
2573	15	ARARUNA	2010-03-11 00:00:00	\N	\N
2574	15	AREIA	2010-03-11 00:00:00	\N	\N
2575	15	AREIA DE BARAÚNAS	2010-03-11 00:00:00	\N	\N
2576	15	AREIAL	2010-03-11 00:00:00	\N	\N
2577	15	AROEIRAS	2010-03-11 00:00:00	\N	\N
2578	15	ASSUNÇÃO	2010-03-11 00:00:00	\N	\N
2579	15	BAÍA DA TRAIÇÃO	2010-03-11 00:00:00	\N	\N
2580	15	BANANEIRAS	2010-03-11 00:00:00	\N	\N
2581	15	BARAÚNA	2010-03-11 00:00:00	\N	\N
2582	15	BARRA DE SANTA ROSA	2010-03-11 00:00:00	\N	\N
2583	15	BARRA DE SANTANA	2010-03-11 00:00:00	\N	\N
2584	15	BARRA DE SÃO MIGUEL	2010-03-11 00:00:00	\N	\N
2585	15	BAYEUX	2010-03-11 00:00:00	\N	\N
2586	15	BELÉM	2010-03-11 00:00:00	\N	\N
2587	15	BELÉM DO BREJO DA CRUZ	2010-03-11 00:00:00	\N	\N
2588	15	BERNARDINO BATISTA	2010-03-11 00:00:00	\N	\N
2589	15	BOA VENTURA	2010-03-11 00:00:00	\N	\N
2590	15	BOA VISTA	2010-03-11 00:00:00	\N	\N
2591	15	BOM JESUS	2010-03-11 00:00:00	\N	\N
2592	15	BOM SUCESSO	2010-03-11 00:00:00	\N	\N
2593	15	BONITO DE SANTA FÉ	2010-03-11 00:00:00	\N	\N
2594	15	BOQUEIRÃO	2010-03-11 00:00:00	\N	\N
2595	15	BORBOREMA	2010-03-11 00:00:00	\N	\N
2596	15	BREJO DO CRUZ	2010-03-11 00:00:00	\N	\N
2597	15	BREJO DOS SANTOS	2010-03-11 00:00:00	\N	\N
2598	15	CAAPORÃ	2010-03-11 00:00:00	\N	\N
2599	15	CABACEIRAS	2010-03-11 00:00:00	\N	\N
2600	15	CABEDELO	2010-03-11 00:00:00	\N	\N
2601	15	CACHOEIRA DOS ÍNDIOS	2010-03-11 00:00:00	\N	\N
2602	15	CACIMBA DE AREIA	2010-03-11 00:00:00	\N	\N
2603	15	CACIMBA DE DENTRO	2010-03-11 00:00:00	\N	\N
2604	15	CACIMBAS	2010-03-11 00:00:00	\N	\N
2605	15	CAIÇARA	2010-03-11 00:00:00	\N	\N
2606	15	CAJAZEIRAS	2010-03-11 00:00:00	\N	\N
2607	15	CAJAZEIRINHAS	2010-03-11 00:00:00	\N	\N
2608	15	CALDAS BRANDÃO	2010-03-11 00:00:00	\N	\N
2609	15	CAMALAÚ	2010-03-11 00:00:00	\N	\N
2610	15	CAMPINA GRANDE	2010-03-11 00:00:00	\N	\N
2611	15	CAMPO DE SANTANA	2010-03-11 00:00:00	\N	\N
2612	15	CAPIM	2010-03-11 00:00:00	\N	\N
2613	15	CARAÚBAS	2010-03-11 00:00:00	\N	\N
2614	15	CARRAPATEIRA	2010-03-11 00:00:00	\N	\N
2615	15	CASSERENGUE	2010-03-11 00:00:00	\N	\N
2616	15	CATINGUEIRA	2010-03-11 00:00:00	\N	\N
2617	15	CATOLÉ DO ROCHA	2010-03-11 00:00:00	\N	\N
2618	15	CATURITÉ	2010-03-11 00:00:00	\N	\N
2619	15	CONCEIÇÃO	2010-03-11 00:00:00	\N	\N
2620	15	CONDADO	2010-03-11 00:00:00	\N	\N
2621	15	CONDE	2010-03-11 00:00:00	\N	\N
2622	15	CONGO	2010-03-11 00:00:00	\N	\N
2623	15	COREMAS	2010-03-11 00:00:00	\N	\N
2624	15	COXIXOLA	2010-03-11 00:00:00	\N	\N
2625	15	CRUZ DO ESPÍRITO SANTO	2010-03-11 00:00:00	\N	\N
2626	15	CUBATI	2010-03-11 00:00:00	\N	\N
2627	15	CUITÉ	2010-03-11 00:00:00	\N	\N
2628	15	CUITÉ DE MAMANGUAPE	2010-03-11 00:00:00	\N	\N
2629	15	CUITEGI	2010-03-11 00:00:00	\N	\N
2630	15	CURRAL DE CIMA	2010-03-11 00:00:00	\N	\N
2631	15	CURRAL VELHO	2010-03-11 00:00:00	\N	\N
2632	15	DAMIÃO	2010-03-11 00:00:00	\N	\N
2633	15	DESTERRO	2010-03-11 00:00:00	\N	\N
2634	15	DIAMANTE	2010-03-11 00:00:00	\N	\N
2635	15	DONA INÊS	2010-03-11 00:00:00	\N	\N
2636	15	DUAS ESTRADAS	2010-03-11 00:00:00	\N	\N
2637	15	EMAS	2010-03-11 00:00:00	\N	\N
2638	15	ESPERANÇA	2010-03-11 00:00:00	\N	\N
2639	15	FAGUNDES	2010-03-11 00:00:00	\N	\N
2640	15	FREI MARTINHO	2010-03-11 00:00:00	\N	\N
2641	15	GADO BRAVO	2010-03-11 00:00:00	\N	\N
2642	15	GUARABIRA	2010-03-11 00:00:00	\N	\N
2643	15	GURINHÉM	2010-03-11 00:00:00	\N	\N
2644	15	GURJÃO	2010-03-11 00:00:00	\N	\N
2645	15	IBIARA	2010-03-11 00:00:00	\N	\N
2646	15	IGARACY	2010-03-11 00:00:00	\N	\N
2647	15	IMACULADA	2010-03-11 00:00:00	\N	\N
2648	15	INGÁ	2010-03-11 00:00:00	\N	\N
2649	15	ITABAIANA	2010-03-11 00:00:00	\N	\N
2650	15	ITAPORANGA	2010-03-11 00:00:00	\N	\N
2651	15	ITAPOROROCA	2010-03-11 00:00:00	\N	\N
2652	15	ITATUBA	2010-03-11 00:00:00	\N	\N
2653	15	JACARAÚ	2010-03-11 00:00:00	\N	\N
2654	15	JERICÓ	2010-03-11 00:00:00	\N	\N
2655	15	JOÃO PESSOA	2010-03-11 00:00:00	\N	\N
2656	15	JUAREZ TÁVORA	2010-03-11 00:00:00	\N	\N
2657	15	JUAZEIRINHO	2010-03-11 00:00:00	\N	\N
2658	15	JUNCO DO SERIDÓ	2010-03-11 00:00:00	\N	\N
2659	15	JURIPIRANGA	2010-03-11 00:00:00	\N	\N
2660	15	JURU	2010-03-11 00:00:00	\N	\N
2661	15	LAGOA	2010-03-11 00:00:00	\N	\N
2662	15	LAGOA DE DENTRO	2010-03-11 00:00:00	\N	\N
2663	15	LAGOA SECA	2010-03-11 00:00:00	\N	\N
2664	15	LASTRO	2010-03-11 00:00:00	\N	\N
2665	15	LIVRAMENTO	2010-03-11 00:00:00	\N	\N
2666	15	LOGRADOURO	2010-03-11 00:00:00	\N	\N
2667	15	LUCENA	2010-03-11 00:00:00	\N	\N
2668	15	MÃE D ÁGUA	2010-03-11 00:00:00	\N	\N
2669	15	MALTA	2010-03-11 00:00:00	\N	\N
2670	15	MAMANGUAPE	2010-03-11 00:00:00	\N	\N
2671	15	MANAÍRA	2010-03-11 00:00:00	\N	\N
2672	15	MARCAÇÃO	2010-03-11 00:00:00	\N	\N
2673	15	MARI	2010-03-11 00:00:00	\N	\N
2674	15	MARIZÓPOLIS	2010-03-11 00:00:00	\N	\N
2675	15	MASSARANDUBA	2010-03-11 00:00:00	\N	\N
2676	15	MATARACA	2010-03-11 00:00:00	\N	\N
2677	15	MATINHAS	2010-03-11 00:00:00	\N	\N
2678	15	MATO GROSSO	2010-03-11 00:00:00	\N	\N
2679	15	MATURÉIA	2010-03-11 00:00:00	\N	\N
2680	15	MOGEIRO	2010-03-11 00:00:00	\N	\N
2681	15	MONTADAS	2010-03-11 00:00:00	\N	\N
2682	15	MONTE HOREBE	2010-03-11 00:00:00	\N	\N
2683	15	MONTEIRO	2010-03-11 00:00:00	\N	\N
2684	15	MULUNGU	2010-03-11 00:00:00	\N	\N
2685	15	NATUBA	2010-03-11 00:00:00	\N	\N
2686	15	NAZAREZINHO	2010-03-11 00:00:00	\N	\N
2687	15	NOVA FLORESTA	2010-03-11 00:00:00	\N	\N
2688	15	NOVA OLINDA	2010-03-11 00:00:00	\N	\N
2689	15	NOVA PALMEIRA	2010-03-11 00:00:00	\N	\N
2690	15	OLHO D ÁGUA	2010-03-11 00:00:00	\N	\N
2691	15	OLIVEDOS	2010-03-11 00:00:00	\N	\N
2692	15	OURO VELHO	2010-03-11 00:00:00	\N	\N
2693	15	PARARI	2010-03-11 00:00:00	\N	\N
2694	15	PASSAGEM	2010-03-11 00:00:00	\N	\N
2695	15	PATOS	2010-03-11 00:00:00	\N	\N
2696	15	PAULISTA	2010-03-11 00:00:00	\N	\N
2697	15	PEDRA BRANCA	2010-03-11 00:00:00	\N	\N
2698	15	PEDRA LAVRADA	2010-03-11 00:00:00	\N	\N
2699	15	PEDRAS DE FOGO	2010-03-11 00:00:00	\N	\N
2700	15	PEDRO RÉGIS	2010-03-11 00:00:00	\N	\N
2701	15	PIANCÓ	2010-03-11 00:00:00	\N	\N
2702	15	PICUÍ	2010-03-11 00:00:00	\N	\N
2703	15	PILAR	2010-03-11 00:00:00	\N	\N
2704	15	PILÕES	2010-03-11 00:00:00	\N	\N
2705	15	PILÕEZINHOS	2010-03-11 00:00:00	\N	\N
2706	15	PIRPIRITUBA	2010-03-11 00:00:00	\N	\N
2707	15	PITIMBU	2010-03-11 00:00:00	\N	\N
2708	15	POCINHOS	2010-03-11 00:00:00	\N	\N
2709	15	POÇO DANTAS	2010-03-11 00:00:00	\N	\N
2710	15	POÇO DE JOSÉ DE MOURA	2010-03-11 00:00:00	\N	\N
2711	15	POMBAL	2010-03-11 00:00:00	\N	\N
2712	15	PRATA	2010-03-11 00:00:00	\N	\N
2713	15	PRINCESA ISABEL	2010-03-11 00:00:00	\N	\N
2714	15	PUXINANÃ	2010-03-11 00:00:00	\N	\N
2715	15	QUEIMADAS	2010-03-11 00:00:00	\N	\N
2716	15	QUIXABA	2010-03-11 00:00:00	\N	\N
2717	15	REMÍGIO	2010-03-11 00:00:00	\N	\N
2718	15	RIACHÃO	2010-03-11 00:00:00	\N	\N
2719	15	RIACHÃO DO BACAMARTE	2010-03-11 00:00:00	\N	\N
2720	15	RIACHÃO DO POÇO	2010-03-11 00:00:00	\N	\N
2721	15	RIACHO DE SANTO ANTÔNIO	2010-03-11 00:00:00	\N	\N
2722	15	RIACHO DOS CAVALOS	2010-03-11 00:00:00	\N	\N
2723	15	RIO TINTO	2010-03-11 00:00:00	\N	\N
2724	15	SALGADINHO	2010-03-11 00:00:00	\N	\N
2725	15	SALGADO DE SÃO FÉLIX	2010-03-11 00:00:00	\N	\N
2726	15	SANTA CECÍLIA	2010-03-11 00:00:00	\N	\N
2727	15	SANTA CRUZ	2010-03-11 00:00:00	\N	\N
2728	15	SANTA HELENA	2010-03-11 00:00:00	\N	\N
2729	15	SANTA INÊS	2010-03-11 00:00:00	\N	\N
2730	15	SANTA LUZIA	2010-03-11 00:00:00	\N	\N
2731	15	SANTA RITA	2010-03-11 00:00:00	\N	\N
2732	15	SANTA TERESINHA	2010-03-11 00:00:00	\N	\N
2733	15	SANTANA DE MANGUEIRA	2010-03-11 00:00:00	\N	\N
2734	15	SANTANA DOS GARROTES	2010-03-11 00:00:00	\N	\N
2735	15	SANTARÉM	2010-03-11 00:00:00	\N	\N
2736	15	SANTO ANDRÉ	2010-03-11 00:00:00	\N	\N
2737	15	SÃO BENTINHO	2010-03-11 00:00:00	\N	\N
2738	15	SÃO BENTO	2010-03-11 00:00:00	\N	\N
2739	15	SÃO DOMINGOS DE POMBAL	2010-03-11 00:00:00	\N	\N
2740	15	SÃO DOMINGOS DO CARIRI	2010-03-11 00:00:00	\N	\N
2741	15	SÃO FRANCISCO	2010-03-11 00:00:00	\N	\N
2742	15	SÃO JOÃO DO CARIRI	2010-03-11 00:00:00	\N	\N
2743	15	SÃO JOÃO DO RIO DO PEIXE	2010-03-11 00:00:00	\N	\N
2744	15	SÃO JOÃO DO TIGRE	2010-03-11 00:00:00	\N	\N
2745	15	SÃO JOSÉ DA LAGOA TAPADA	2010-03-11 00:00:00	\N	\N
2746	15	SÃO JOSÉ DE CAIANA	2010-03-11 00:00:00	\N	\N
2747	15	SÃO JOSÉ DE ESPINHARAS	2010-03-11 00:00:00	\N	\N
2748	15	SÃO JOSÉ DE PIRANHAS	2010-03-11 00:00:00	\N	\N
2749	15	SÃO JOSÉ DE PRINCESA	2010-03-11 00:00:00	\N	\N
2750	15	SÃO JOSÉ DO BONFIM	2010-03-11 00:00:00	\N	\N
2751	15	SÃO JOSÉ DO BREJO DA CRUZ	2010-03-11 00:00:00	\N	\N
2752	15	SÃO JOSÉ DO SABUGI	2010-03-11 00:00:00	\N	\N
2753	15	SÃO JOSÉ DOS CORDEIROS	2010-03-11 00:00:00	\N	\N
2754	15	SÃO JOSÉ DOS RAMOS	2010-03-11 00:00:00	\N	\N
2755	15	SÃO MAMEDE	2010-03-11 00:00:00	\N	\N
2756	15	SÃO MIGUEL DE TAIPU	2010-03-11 00:00:00	\N	\N
2757	15	SÃO SEBASTIÃO DE LAGOA DE ROÇA	2010-03-11 00:00:00	\N	\N
2758	15	SÃO SEBASTIÃO DO UMBUZEIRO	2010-03-11 00:00:00	\N	\N
2759	15	SAPÉ	2010-03-11 00:00:00	\N	\N
2760	15	SERIDÓ	2010-03-11 00:00:00	\N	\N
2761	15	SERRA BRANCA	2010-03-11 00:00:00	\N	\N
2762	15	SERRA DA RAIZ	2010-03-11 00:00:00	\N	\N
2763	15	SERRA GRANDE	2010-03-11 00:00:00	\N	\N
2764	15	SERRA REDONDA	2010-03-11 00:00:00	\N	\N
2765	15	SERRARIA	2010-03-11 00:00:00	\N	\N
2766	15	SERTÃOZINHO	2010-03-11 00:00:00	\N	\N
2767	15	SOBRADO	2010-03-11 00:00:00	\N	\N
2768	15	SOLÂNEA	2010-03-11 00:00:00	\N	\N
2769	15	SOLEDADE	2010-03-11 00:00:00	\N	\N
2770	15	SOSSEGO	2010-03-11 00:00:00	\N	\N
2771	15	SOUSA	2010-03-11 00:00:00	\N	\N
2772	15	SUMÉ	2010-03-11 00:00:00	\N	\N
2773	15	TAPEROÁ	2010-03-11 00:00:00	\N	\N
2774	15	TAVARES	2010-03-11 00:00:00	\N	\N
2775	15	TEIXEIRA	2010-03-11 00:00:00	\N	\N
2776	15	TENÓRIO	2010-03-11 00:00:00	\N	\N
2777	15	TRIUNFO	2010-03-11 00:00:00	\N	\N
2778	15	UIRAÚNA	2010-03-11 00:00:00	\N	\N
2779	15	UMBUZEIRO	2010-03-11 00:00:00	\N	\N
2780	15	VÁRZEA	2010-03-11 00:00:00	\N	\N
2781	15	VIERÓPOLIS	2010-03-11 00:00:00	\N	\N
2782	15	VISTA SERRANA	2010-03-11 00:00:00	\N	\N
2783	15	ZABELÊ	2010-03-11 00:00:00	\N	\N
2784	16	ABREU E LIMA	2010-03-11 00:00:00	\N	\N
2785	16	AFOGADOS DA INGAZEIRA	2010-03-11 00:00:00	\N	\N
2786	16	AFRÂNIO	2010-03-11 00:00:00	\N	\N
2787	16	AGRESTINA	2010-03-11 00:00:00	\N	\N
2788	16	ÁGUA PRETA	2010-03-11 00:00:00	\N	\N
2789	16	ÁGUAS BELAS	2010-03-11 00:00:00	\N	\N
2790	16	ALAGOINHA	2010-03-11 00:00:00	\N	\N
2791	16	ALIANÇA	2010-03-11 00:00:00	\N	\N
2792	16	ALTINHO	2010-03-11 00:00:00	\N	\N
2793	16	AMARAJÍ	2010-03-11 00:00:00	\N	\N
2794	16	ANGELIM	2010-03-11 00:00:00	\N	\N
2795	16	ARAÇOIABA	2010-03-11 00:00:00	\N	\N
2796	16	ARARIPINA	2010-03-11 00:00:00	\N	\N
2797	16	ARCOVERDE	2010-03-11 00:00:00	\N	\N
2798	16	BARRA DE GUABIRABA	2010-03-11 00:00:00	\N	\N
2799	16	BARREIROS	2010-03-11 00:00:00	\N	\N
2800	16	BELÉM DE  SÃO FRANCISCO	2010-03-11 00:00:00	\N	\N
2801	16	BELÉM DE MARIA	2010-03-11 00:00:00	\N	\N
2802	16	BELO JARDIM	2010-03-11 00:00:00	\N	\N
2803	16	BETÂNIA	2010-03-11 00:00:00	\N	\N
2804	16	BEZERROS	2010-03-11 00:00:00	\N	\N
2805	16	BODOCÓ	2010-03-11 00:00:00	\N	\N
2806	16	BOM CONSELHO	2010-03-11 00:00:00	\N	\N
2807	16	BOM JARDIM	2010-03-11 00:00:00	\N	\N
2808	16	BONITO	2010-03-11 00:00:00	\N	\N
2809	16	BREJÃO	2010-03-11 00:00:00	\N	\N
2810	16	BREJINHO	2010-03-11 00:00:00	\N	\N
2811	16	BREJO DA MADRE DE DEUS	2010-03-11 00:00:00	\N	\N
2812	16	BUENOS AIRES	2010-03-11 00:00:00	\N	\N
2813	16	BUÍQUE	2010-03-11 00:00:00	\N	\N
2814	16	CABO DE SANTO AGOSTINHO	2010-03-11 00:00:00	\N	\N
2815	16	CABROBÓ	2010-03-11 00:00:00	\N	\N
2816	16	CACHOEIRINHA	2010-03-11 00:00:00	\N	\N
2817	16	CAETÉS	2010-03-11 00:00:00	\N	\N
2818	16	CALÇADO	2010-03-11 00:00:00	\N	\N
2819	16	CALUMBÍ	2010-03-11 00:00:00	\N	\N
2820	16	CAMARAGIBE	2010-03-11 00:00:00	\N	\N
2821	16	CAMOCIM DE SÃO FÉLIX	2010-03-11 00:00:00	\N	\N
2822	16	CAMUTANGA	2010-03-11 00:00:00	\N	\N
2823	16	CANHOTINHO	2010-03-11 00:00:00	\N	\N
2824	16	CAPOEIRAS	2010-03-11 00:00:00	\N	\N
2825	16	CARNAÍBA	2010-03-11 00:00:00	\N	\N
2826	16	CARNAUBEIRAS DA PENHA	2010-03-11 00:00:00	\N	\N
2827	16	CARPINA	2010-03-11 00:00:00	\N	\N
2828	16	CARUARU	2010-03-11 00:00:00	\N	\N
2829	16	CASINHAS	2010-03-11 00:00:00	\N	\N
2830	16	CATENDE	2010-03-11 00:00:00	\N	\N
2831	16	CEDRO	2010-03-11 00:00:00	\N	\N
2832	16	CHÃ DE ALEGRIA	2010-03-11 00:00:00	\N	\N
2833	16	CHÃ GRANDE	2010-03-11 00:00:00	\N	\N
2834	16	CONDADO	2010-03-11 00:00:00	\N	\N
2835	16	CORRENTES	2010-03-11 00:00:00	\N	\N
2836	16	CORTÊS	2010-03-11 00:00:00	\N	\N
2837	16	CUMARU	2010-03-11 00:00:00	\N	\N
2838	16	CUPIRA	2010-03-11 00:00:00	\N	\N
2839	16	CUSTÓDIA	2010-03-11 00:00:00	\N	\N
2840	16	DORMENTES	2010-03-11 00:00:00	\N	\N
2841	16	ESCADA	2010-03-11 00:00:00	\N	\N
2842	16	EXÚ	2010-03-11 00:00:00	\N	\N
2843	16	FEIRA NOVA	2010-03-11 00:00:00	\N	\N
2844	16	FERNANDO DE NORONHA	2010-03-11 00:00:00	\N	\N
2845	16	FERREIROS	2010-03-11 00:00:00	\N	\N
2846	16	FLORES	2010-03-11 00:00:00	\N	\N
2847	16	FLORESTA	2010-03-11 00:00:00	\N	\N
2848	16	FREI MIGUELINHO	2010-03-11 00:00:00	\N	\N
2849	16	GAMELEIRA	2010-03-11 00:00:00	\N	\N
2850	16	GARANHUNS	2010-03-11 00:00:00	\N	\N
2851	16	GLÓRIA DO GOITÁ	2010-03-11 00:00:00	\N	\N
2852	16	GOIANA	2010-03-11 00:00:00	\N	\N
2853	16	GRANITO	2010-03-11 00:00:00	\N	\N
2854	16	GRAVATÁ	2010-03-11 00:00:00	\N	\N
2855	16	IATÍ	2010-03-11 00:00:00	\N	\N
2856	16	IBIMIRIM	2010-03-11 00:00:00	\N	\N
2857	16	IBIRAJUBA	2010-03-11 00:00:00	\N	\N
2858	16	IGARASSU	2010-03-11 00:00:00	\N	\N
2859	16	IGUARACI	2010-03-11 00:00:00	\N	\N
2860	16	ILHA DE ITAMARACÁ	2010-03-11 00:00:00	\N	\N
2861	16	INAJÁ	2010-03-11 00:00:00	\N	\N
2862	16	INGAZEIRA	2010-03-11 00:00:00	\N	\N
2863	16	IPOJUCA	2010-03-11 00:00:00	\N	\N
2864	16	IPUBI	2010-03-11 00:00:00	\N	\N
2865	16	ITACURUBA	2010-03-11 00:00:00	\N	\N
2866	16	ITAÍBA	2010-03-11 00:00:00	\N	\N
2867	16	ITAMBÉ	2010-03-11 00:00:00	\N	\N
2868	16	ITAPETIM	2010-03-11 00:00:00	\N	\N
2869	16	ITAPISSUMA	2010-03-11 00:00:00	\N	\N
2870	16	ITAQUITINGA	2010-03-11 00:00:00	\N	\N
2871	16	JABOATÃO DOS GUARARAPES	2010-03-11 00:00:00	\N	\N
2872	16	JAQUEIRA	2010-03-11 00:00:00	\N	\N
2873	16	JATAÚBA	2010-03-11 00:00:00	\N	\N
2874	16	JATOBÁ	2010-03-11 00:00:00	\N	\N
2875	16	JOÃO ALFREDO	2010-03-11 00:00:00	\N	\N
2876	16	JOAQUIM NABUCO	2010-03-11 00:00:00	\N	\N
2877	16	JUCATI	2010-03-11 00:00:00	\N	\N
2878	16	JUPÍ	2010-03-11 00:00:00	\N	\N
2879	16	JUREMA	2010-03-11 00:00:00	\N	\N
2880	16	LAGOA DO CARRO	2010-03-11 00:00:00	\N	\N
2881	16	LAGOA DO ITAENGA	2010-03-11 00:00:00	\N	\N
2882	16	LAGOA DO OURO	2010-03-11 00:00:00	\N	\N
2883	16	LAGOA DOS GATOS	2010-03-11 00:00:00	\N	\N
2884	16	LAGOA GRANDE	2010-03-11 00:00:00	\N	\N
2885	16	LAJEDO	2010-03-11 00:00:00	\N	\N
2886	16	LIMOEIRO	2010-03-11 00:00:00	\N	\N
2887	16	MACAPARANA	2010-03-11 00:00:00	\N	\N
2888	16	MACHADOS	2010-03-11 00:00:00	\N	\N
2889	16	MANARI	2010-03-11 00:00:00	\N	\N
2890	16	MARAIAL	2010-03-11 00:00:00	\N	\N
2891	16	MIRANDIBA	2010-03-11 00:00:00	\N	\N
2892	16	MOREILÂNDIA	2010-03-11 00:00:00	\N	\N
2893	16	MORENO	2010-03-11 00:00:00	\N	\N
2894	16	NAZARÉ DA MATA	2010-03-11 00:00:00	\N	\N
2895	16	OLINDA	2010-03-11 00:00:00	\N	\N
2896	16	OROBÓ	2010-03-11 00:00:00	\N	\N
2897	16	OROCÓ	2010-03-11 00:00:00	\N	\N
2898	16	OURICURI	2010-03-11 00:00:00	\N	\N
2899	16	PALMARES	2010-03-11 00:00:00	\N	\N
2900	16	PALMEIRINA	2010-03-11 00:00:00	\N	\N
2901	16	PANELAS	2010-03-11 00:00:00	\N	\N
2902	16	PARANATAMA	2010-03-11 00:00:00	\N	\N
2903	16	PARNAMIRIM	2010-03-11 00:00:00	\N	\N
2904	16	PASSIRA	2010-03-11 00:00:00	\N	\N
2905	16	PAUDALHO	2010-03-11 00:00:00	\N	\N
2906	16	PAULISTA	2010-03-11 00:00:00	\N	\N
2907	16	PEDRA	2010-03-11 00:00:00	\N	\N
2908	16	PESQUEIRA	2010-03-11 00:00:00	\N	\N
2909	16	PETROLÂNDIA	2010-03-11 00:00:00	\N	\N
2910	16	PETROLINA	2010-03-11 00:00:00	\N	\N
2911	16	POÇÃO	2010-03-11 00:00:00	\N	\N
2912	16	POMBOS	2010-03-11 00:00:00	\N	\N
2913	16	PRIMAVERA	2010-03-11 00:00:00	\N	\N
2914	16	QUIPAPÁ	2010-03-11 00:00:00	\N	\N
2915	16	QUIXABA	2010-03-11 00:00:00	\N	\N
2916	16	RECIFE	2010-03-11 00:00:00	\N	\N
2917	16	RIACHO DAS ALMAS	2010-03-11 00:00:00	\N	\N
2918	16	RIBEIRÃO	2010-03-11 00:00:00	\N	\N
2919	16	RIO FORMOSO	2010-03-11 00:00:00	\N	\N
2920	16	SAIRÉ	2010-03-11 00:00:00	\N	\N
2921	16	SALGADINHO	2010-03-11 00:00:00	\N	\N
2922	16	SALGUEIRO	2010-03-11 00:00:00	\N	\N
2923	16	SALOÁ	2010-03-11 00:00:00	\N	\N
2924	16	SANHARÓ	2010-03-11 00:00:00	\N	\N
2925	16	SANTA CRUZ	2010-03-11 00:00:00	\N	\N
2926	16	SANTA CRUZ DA BAIXA VERDE	2010-03-11 00:00:00	\N	\N
2927	16	SANTA CRUZ DO CAPIBARIBE	2010-03-11 00:00:00	\N	\N
2928	16	SANTA FILOMENA	2010-03-11 00:00:00	\N	\N
2929	16	SANTA MARIA DA BOA VISTA	2010-03-11 00:00:00	\N	\N
2930	16	SANTA MARIA DO CAMBUCÁ	2010-03-11 00:00:00	\N	\N
2931	16	SANTA TEREZINHA	2010-03-11 00:00:00	\N	\N
2932	16	SÃO BENEDITO DO SUL	2010-03-11 00:00:00	\N	\N
2933	16	SÃO BENTO DO UNA	2010-03-11 00:00:00	\N	\N
2934	16	SÃO CAITANO	2010-03-11 00:00:00	\N	\N
2935	16	SÃO JOÃO	2010-03-11 00:00:00	\N	\N
2936	16	SÃO JOAQUIM DO MONTE	2010-03-11 00:00:00	\N	\N
2937	16	SÃO JOSÉ DA COROA GRANDE	2010-03-11 00:00:00	\N	\N
2938	16	SÃO JOSÉ DO BELMONTE	2010-03-11 00:00:00	\N	\N
2939	16	SÃO JOSÉ DO EGITO	2010-03-11 00:00:00	\N	\N
2940	16	SÃO LOURENÇO DA MATA	2010-03-11 00:00:00	\N	\N
2941	16	SÃO VICENTE FERRER	2010-03-11 00:00:00	\N	\N
2942	16	SERRA TALHADA	2010-03-11 00:00:00	\N	\N
2943	16	SERRITA	2010-03-11 00:00:00	\N	\N
2944	16	SERTÂNIA	2010-03-11 00:00:00	\N	\N
2945	16	SIRINHAÉM	2010-03-11 00:00:00	\N	\N
2946	16	SOLIDÃO	2010-03-11 00:00:00	\N	\N
2947	16	SURUBIM	2010-03-11 00:00:00	\N	\N
2948	16	TABIRA	2010-03-11 00:00:00	\N	\N
2949	16	TACAIMBÓ	2010-03-11 00:00:00	\N	\N
2950	16	TACARATU	2010-03-11 00:00:00	\N	\N
2951	16	TAMANDARÉ	2010-03-11 00:00:00	\N	\N
2952	16	TAQUARITINGA DO NORTE	2010-03-11 00:00:00	\N	\N
2953	16	TEREZINHA	2010-03-11 00:00:00	\N	\N
2954	16	TERRA NOVA	2010-03-11 00:00:00	\N	\N
2955	16	TIMBAÚBA	2010-03-11 00:00:00	\N	\N
2956	16	TORITAMA	2010-03-11 00:00:00	\N	\N
2957	16	TRACUNHAÉM	2010-03-11 00:00:00	\N	\N
2958	16	TRINDADE	2010-03-11 00:00:00	\N	\N
2959	16	TRIUNFO	2010-03-11 00:00:00	\N	\N
2960	16	TUPANATINGA	2010-03-11 00:00:00	\N	\N
2961	16	TUPARETAMA	2010-03-11 00:00:00	\N	\N
2962	16	VENTUROSA	2010-03-11 00:00:00	\N	\N
2963	16	VERDEJANTE	2010-03-11 00:00:00	\N	\N
2964	16	VERTENTE DO LÉRIO	2010-03-11 00:00:00	\N	\N
2965	16	VERTENTES	2010-03-11 00:00:00	\N	\N
2966	16	VICÊNCIA	2010-03-11 00:00:00	\N	\N
2967	16	VITÓRIA DE SANTO ANTÃO	2010-03-11 00:00:00	\N	\N
2968	16	XEXÉU	2010-03-11 00:00:00	\N	\N
2969	17	ACAUÃ	2010-03-11 00:00:00	\N	\N
2970	17	AGRICOLÂNDIA	2010-03-11 00:00:00	\N	\N
2971	17	ÁGUA BRANCA	2010-03-11 00:00:00	\N	\N
2972	17	ALAGOINHA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
2973	17	ALEGRETE DO PIAUÍ	2010-03-11 00:00:00	\N	\N
2974	17	ALTO LONGÁ	2010-03-11 00:00:00	\N	\N
2975	17	ALTOS	2010-03-11 00:00:00	\N	\N
2976	17	ALVORADA DO GURGUÉIA	2010-03-11 00:00:00	\N	\N
2977	17	AMARANTE	2010-03-11 00:00:00	\N	\N
2978	17	ANGICAL DO PIAUÍ	2010-03-11 00:00:00	\N	\N
2979	17	ANÍSIO DE ABREU	2010-03-11 00:00:00	\N	\N
2980	17	ANTÔNIO ALMEIDA	2010-03-11 00:00:00	\N	\N
2981	17	AROAZES	2010-03-11 00:00:00	\N	\N
2982	17	AROEIRAS DO ITAIM	2010-03-11 00:00:00	\N	\N
2983	17	ARRAIAL	2010-03-11 00:00:00	\N	\N
2984	17	ASSUNÇÃO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
2985	17	AVELINO LOPES	2010-03-11 00:00:00	\N	\N
2986	17	BAIXA GRANDE DO RIBEIRO	2010-03-11 00:00:00	\N	\N
2987	17	BARRA D ALCÂNTARA	2010-03-11 00:00:00	\N	\N
2988	17	BARRAS	2010-03-11 00:00:00	\N	\N
2989	17	BARREIRAS DO PIAUÍ	2010-03-11 00:00:00	\N	\N
2990	17	BARRO DURO	2010-03-11 00:00:00	\N	\N
2991	17	BATALHA	2010-03-11 00:00:00	\N	\N
2992	17	BELA VISTA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
2993	17	BELÉM DO PIAUÍ	2010-03-11 00:00:00	\N	\N
2994	17	BENEDITINOS	2010-03-11 00:00:00	\N	\N
2995	17	BERTOLÍNIA	2010-03-11 00:00:00	\N	\N
2996	17	BETÂNIA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
2997	17	BOA HORA	2010-03-11 00:00:00	\N	\N
2998	17	BOCAINA	2010-03-11 00:00:00	\N	\N
2999	17	BOM JESUS	2010-03-11 00:00:00	\N	\N
3000	17	BOM PRINCÍPIO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3001	17	BONFIM DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3002	17	BOQUEIRÃO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3003	17	BRASILEIRA	2010-03-11 00:00:00	\N	\N
3004	17	BREJO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3005	17	BURITI DOS LOPES	2010-03-11 00:00:00	\N	\N
3006	17	BURITI DOS MONTES	2010-03-11 00:00:00	\N	\N
3007	17	CABECEIRAS DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3008	17	CAJAZEIRAS DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3009	17	CAJUEIRO DA PRAIA	2010-03-11 00:00:00	\N	\N
3010	17	CALDEIRÃO GRANDE DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3011	17	CAMPINAS DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3012	17	CAMPO ALEGRE DO FIDALGO	2010-03-11 00:00:00	\N	\N
3013	17	CAMPO GRANDE DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3014	17	CAMPO LARGO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3015	17	CAMPO MAIOR	2010-03-11 00:00:00	\N	\N
3016	17	CANAVIEIRA	2010-03-11 00:00:00	\N	\N
3017	17	CANTO DO BURITI	2010-03-11 00:00:00	\N	\N
3018	17	CAPITÃO DE CAMPOS	2010-03-11 00:00:00	\N	\N
3019	17	CAPITÃO GERVÁSIO OLIVEIRA	2010-03-11 00:00:00	\N	\N
3020	17	CARACOL	2010-03-11 00:00:00	\N	\N
3021	17	CARAÚBAS DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3022	17	CARIDADE DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3023	17	CASTELO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3024	17	CAXINGÓ	2010-03-11 00:00:00	\N	\N
3025	17	COCAL	2010-03-11 00:00:00	\N	\N
3026	17	COCAL DE TELHA	2010-03-11 00:00:00	\N	\N
3027	17	COCAL DO ALVES	2010-03-11 00:00:00	\N	\N
3028	17	COIVARAS	2010-03-11 00:00:00	\N	\N
3029	17	COLÔNIA DO GURGUÉIA	2010-03-11 00:00:00	\N	\N
3030	17	COLÔNIA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3031	17	CONCEIÇÃO DO CANINDÉ	2010-03-11 00:00:00	\N	\N
3032	17	CORONEL JOSÉ DIAS	2010-03-11 00:00:00	\N	\N
3033	17	CORRENTE	2010-03-11 00:00:00	\N	\N
3034	17	CRISTALÂNDIA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3035	17	CRISTINO CASTRO	2010-03-11 00:00:00	\N	\N
3036	17	CURIMATÁ	2010-03-11 00:00:00	\N	\N
3037	17	CURRAIS	2010-03-11 00:00:00	\N	\N
3038	17	CURRAL NOVO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3039	17	CURRALINHOS	2010-03-11 00:00:00	\N	\N
3040	17	DEMERVAL LOBÃO	2010-03-11 00:00:00	\N	\N
3041	17	DIRCEU ARCOVERDE	2010-03-11 00:00:00	\N	\N
3042	17	DOM EXPEDITO LOPES	2010-03-11 00:00:00	\N	\N
3043	17	DOM INOCÊNCIO	2010-03-11 00:00:00	\N	\N
3044	17	DOMINGOS MOURÃO	2010-03-11 00:00:00	\N	\N
3045	17	ELESBÃO VELOSO	2010-03-11 00:00:00	\N	\N
3046	17	ELISEU MARTINS	2010-03-11 00:00:00	\N	\N
3047	17	ESPERANTINA	2010-03-11 00:00:00	\N	\N
3048	17	FARTURA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3049	17	FLORES DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3050	17	FLORESTA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3051	17	FLORIANO	2010-03-11 00:00:00	\N	\N
3052	17	FRANCINÓPOLIS	2010-03-11 00:00:00	\N	\N
3053	17	FRANCISCO AYRES	2010-03-11 00:00:00	\N	\N
3054	17	FRANCISCO MACEDO	2010-03-11 00:00:00	\N	\N
3055	17	FRANCISCO SANTOS	2010-03-11 00:00:00	\N	\N
3056	17	FRONTEIRAS	2010-03-11 00:00:00	\N	\N
3057	17	GEMINIANO	2010-03-11 00:00:00	\N	\N
3058	17	GILBUÉS	2010-03-11 00:00:00	\N	\N
3059	17	GUADALUPE	2010-03-11 00:00:00	\N	\N
3060	17	GUARIBAS	2010-03-11 00:00:00	\N	\N
3061	17	HUGO NAPOLEÃO	2010-03-11 00:00:00	\N	\N
3062	17	ILHA GRANDE	2010-03-11 00:00:00	\N	\N
3063	17	INHUMA	2010-03-11 00:00:00	\N	\N
3064	17	IPIRANGA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3065	17	ISAIAS COELHO	2010-03-11 00:00:00	\N	\N
3066	17	ITAINÓPOLIS	2010-03-11 00:00:00	\N	\N
3067	17	ITAUEIRA	2010-03-11 00:00:00	\N	\N
3068	17	JACOBINA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3069	17	JAICÓS	2010-03-11 00:00:00	\N	\N
3070	17	JARDIM DO MULATO	2010-03-11 00:00:00	\N	\N
3071	17	JATOBÁ DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3072	17	JERUMENHA	2010-03-11 00:00:00	\N	\N
3073	17	JOÃO COSTA	2010-03-11 00:00:00	\N	\N
3074	17	JOAQUIM PIRES	2010-03-11 00:00:00	\N	\N
3075	17	JOCA MARQUES	2010-03-11 00:00:00	\N	\N
3076	17	JOSÉ DE FREITAS	2010-03-11 00:00:00	\N	\N
3077	17	JUAZEIRO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3078	17	JÚLIO BORGES	2010-03-11 00:00:00	\N	\N
3079	17	JUREMA	2010-03-11 00:00:00	\N	\N
3080	17	LAGOA ALEGRE	2010-03-11 00:00:00	\N	\N
3081	17	LAGOA DO BARRO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3082	17	LAGOA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3083	17	LAGOA DO SÃO FRANCISCO	2010-03-11 00:00:00	\N	\N
3084	17	LAGOA DO SÍTIO	2010-03-11 00:00:00	\N	\N
3085	17	LAGOINHA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3086	17	LANDRI SALES	2010-03-11 00:00:00	\N	\N
3087	17	LUÍS CORREIA	2010-03-11 00:00:00	\N	\N
3088	17	LUZILÂNDIA	2010-03-11 00:00:00	\N	\N
3089	17	MADEIRO	2010-03-11 00:00:00	\N	\N
3090	17	MANOEL EMÍDIO	2010-03-11 00:00:00	\N	\N
3091	17	MARCOLÂNDIA	2010-03-11 00:00:00	\N	\N
3092	17	MARCOS PARENTE	2010-03-11 00:00:00	\N	\N
3093	17	MASSAPÊ DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3094	17	MATIAS OLÍMPIO	2010-03-11 00:00:00	\N	\N
3095	17	MIGUEL ALVES	2010-03-11 00:00:00	\N	\N
3096	17	MIGUEL LEÃO	2010-03-11 00:00:00	\N	\N
3097	17	MILTON BRANDÃO	2010-03-11 00:00:00	\N	\N
3098	17	MONSENHOR GIL	2010-03-11 00:00:00	\N	\N
3099	17	MONSENHOR HIPÓLITO	2010-03-11 00:00:00	\N	\N
3100	17	MONTE ALEGRE DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3101	17	MORRO CABEÇA NO TEMPO	2010-03-11 00:00:00	\N	\N
3102	17	MORRO DO CHAPÉU DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3103	17	MURICI DOS PORTELAS	2010-03-11 00:00:00	\N	\N
3104	17	NAZARÉ DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3105	17	NOSSA SENHORA DE NAZARÉ	2010-03-11 00:00:00	\N	\N
3106	17	NOSSA SENHORA DOS REMÉDIOS	2010-03-11 00:00:00	\N	\N
3107	17	NOVA SANTA RITA	2010-03-11 00:00:00	\N	\N
3108	17	NOVO ORIENTE DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3109	17	NOVO SANTO ANTÔNIO	2010-03-11 00:00:00	\N	\N
3110	17	OEIRAS	2010-03-11 00:00:00	\N	\N
3111	17	OLHO D ÁGUA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3112	17	PADRE MARCOS	2010-03-11 00:00:00	\N	\N
3113	17	PAES LANDIM	2010-03-11 00:00:00	\N	\N
3114	17	PAJEÚ DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3115	17	PALMEIRA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3116	17	PALMERAIS	2010-03-11 00:00:00	\N	\N
3117	17	PAQUETÁ	2010-03-11 00:00:00	\N	\N
3118	17	PARNAGUÁ	2010-03-11 00:00:00	\N	\N
3119	17	PARNAÍBA	2010-03-11 00:00:00	\N	\N
3120	17	PASSAGEM FRANCA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3121	17	PATOS DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3122	17	PAU D´ARCO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3123	17	PAULISTANA	2010-03-11 00:00:00	\N	\N
3124	17	PAVUSSU	2010-03-11 00:00:00	\N	\N
3125	17	PEDRO II	2010-03-11 00:00:00	\N	\N
3126	17	PEDRO LAURENTINO	2010-03-11 00:00:00	\N	\N
3127	17	PICOS	2010-03-11 00:00:00	\N	\N
3128	17	PIMENTEIRAS	2010-03-11 00:00:00	\N	\N
3129	17	PIO IX	2010-03-11 00:00:00	\N	\N
3130	17	PIRACURUCA	2010-03-11 00:00:00	\N	\N
3131	17	PIRIPIRI	2010-03-11 00:00:00	\N	\N
3132	17	PORTO	2010-03-11 00:00:00	\N	\N
3133	17	PORTO ALEGRE DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3134	17	PRATA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3135	17	QUEIMADA NOVA	2010-03-11 00:00:00	\N	\N
3136	17	REDENÇÃO DO GURGUÉIA	2010-03-11 00:00:00	\N	\N
3137	17	REGENERAÇÃO	2010-03-11 00:00:00	\N	\N
3138	17	RIACHO FRIO	2010-03-11 00:00:00	\N	\N
3139	17	RIBEIRA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3140	17	RIBEIRO GONÇALVES	2010-03-11 00:00:00	\N	\N
3141	17	RIO GRANDE DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3142	17	SANTA CRUZ DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3143	17	SANTA CRUZ DOS MILAGRES	2010-03-11 00:00:00	\N	\N
3144	17	SANTA FILOMENA	2010-03-11 00:00:00	\N	\N
3145	17	SANTA LUZ	2010-03-11 00:00:00	\N	\N
3146	17	SANTA ROSA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3147	17	SANTANA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3148	17	SANTO ANTÔNIO DE LISBOA	2010-03-11 00:00:00	\N	\N
3149	17	SANTO ANTÔNIO DOS MILAGRES	2010-03-11 00:00:00	\N	\N
3150	17	SANTO INÁCIO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3151	17	SÃO BRAZ DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3152	17	SÃO FÉLIX DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3153	17	SÃO FRANCISCO DE ASSIS DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3154	17	SÃO FRANCISCO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3155	17	SÃO GONÇALO DO GURGUÉIA	2010-03-11 00:00:00	\N	\N
3156	17	SÃO GONÇALO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3157	17	SÃO JOÃO DA CANABRAVA	2010-03-11 00:00:00	\N	\N
3158	17	SÃO JOÃO DA FRONTEIRA	2010-03-11 00:00:00	\N	\N
3159	17	SÃO JOÃO DA SERRA	2010-03-11 00:00:00	\N	\N
3160	17	SÃO JOÃO DA VARJOTA	2010-03-11 00:00:00	\N	\N
3161	17	SÃO JOÃO DO ARRAIAL	2010-03-11 00:00:00	\N	\N
3162	17	SÃO JOÃO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3163	17	SÃO JOSÉ DO DIVINO	2010-03-11 00:00:00	\N	\N
3164	17	SÃO JOSÉ DO PEIXE	2010-03-11 00:00:00	\N	\N
3165	17	SÃO JOSÉ DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3166	17	SÃO JULIÃO	2010-03-11 00:00:00	\N	\N
3167	17	SÃO LOURENÇO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3168	17	SÃO LUÍS DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3169	17	SÃO MIGUEL DA BAIXA GRANDE	2010-03-11 00:00:00	\N	\N
3170	17	SÃO MIGUEL DO FIDALGO	2010-03-11 00:00:00	\N	\N
3171	17	SÃO MIGUEL DO TAPUIO	2010-03-11 00:00:00	\N	\N
3172	17	SÃO PEDRO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3173	17	SÃO RAIMUNDO NONATO	2010-03-11 00:00:00	\N	\N
3174	17	SEBASTIÃO BARROS	2010-03-11 00:00:00	\N	\N
3175	17	SEBASTIÃO LEAL	2010-03-11 00:00:00	\N	\N
3176	17	SIGEFREDO PACHECO	2010-03-11 00:00:00	\N	\N
3177	17	SIMÕES	2010-03-11 00:00:00	\N	\N
3178	17	SIMPLÍCIO MENDES	2010-03-11 00:00:00	\N	\N
3179	17	SOCORRO DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3180	17	SUSSUAPARA	2010-03-11 00:00:00	\N	\N
3181	17	TAMBORIL DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3182	17	TANQUE DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3183	17	TERESINA	2010-03-11 00:00:00	\N	\N
3184	17	UNIÃO	2010-03-11 00:00:00	\N	\N
3185	17	URUÇUÍ	2010-03-11 00:00:00	\N	\N
3186	17	VALENÇA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3187	17	VÁRZEA BRANCA	2010-03-11 00:00:00	\N	\N
3188	17	VÁRZEA GRANDE	2010-03-11 00:00:00	\N	\N
3189	17	VERA MENDES	2010-03-11 00:00:00	\N	\N
3190	17	VILA NOVA DO PIAUÍ	2010-03-11 00:00:00	\N	\N
3191	17	WALL FERRAZ	2010-03-11 00:00:00	\N	\N
3192	18	ABATIA	2010-03-11 00:00:00	\N	\N
3193	18	ADRIANÓPOLIS	2010-03-11 00:00:00	\N	\N
3194	18	AGUDOS DO SUL	2010-03-11 00:00:00	\N	\N
3195	18	ALMIRANTE TAMANDARÉ	2010-03-11 00:00:00	\N	\N
3196	18	ALTAMIRA DO PARANÁ	2010-03-11 00:00:00	\N	\N
3197	18	ALTO PARAÍSO	2010-03-11 00:00:00	\N	\N
3198	18	ALTO PARANÁ	2010-03-11 00:00:00	\N	\N
3199	18	ALTO PIQUIRI	2010-03-11 00:00:00	\N	\N
3200	18	ALTONIA	2010-03-11 00:00:00	\N	\N
3201	18	ALVORADA DO SUL	2010-03-11 00:00:00	\N	\N
3202	18	AMAPORÃ	2010-03-11 00:00:00	\N	\N
3203	18	AMPERE	2010-03-11 00:00:00	\N	\N
3204	18	ANAHY	2010-03-11 00:00:00	\N	\N
3205	18	ANDIRA	2010-03-11 00:00:00	\N	\N
3206	18	ÂNGULO	2010-03-11 00:00:00	\N	\N
3207	18	ANTONINA	2010-03-11 00:00:00	\N	\N
3208	18	ANTONIO OLINTO	2010-03-11 00:00:00	\N	\N
3209	18	APUCARANA	2010-03-11 00:00:00	\N	\N
3210	18	ARAPONGAS	2010-03-11 00:00:00	\N	\N
3211	18	ARAPOTI	2010-03-11 00:00:00	\N	\N
3212	18	ARAPUA	2010-03-11 00:00:00	\N	\N
3213	18	ARARUNA	2010-03-11 00:00:00	\N	\N
3214	18	ARAUCÁRIA	2010-03-11 00:00:00	\N	\N
3215	18	ARIRANHA DO IVAÍ	2010-03-11 00:00:00	\N	\N
3216	18	ASSAÍ	2010-03-11 00:00:00	\N	\N
3217	18	ASSIS CHATEAUBRIAND	2010-03-11 00:00:00	\N	\N
3218	18	ASTORGA	2010-03-11 00:00:00	\N	\N
3219	18	ATALAIA	2010-03-11 00:00:00	\N	\N
3220	18	BALSA NOVA	2010-03-11 00:00:00	\N	\N
3221	18	BANDEIRANTES	2010-03-11 00:00:00	\N	\N
3222	18	BARBOSA FERRAZ	2010-03-11 00:00:00	\N	\N
3223	18	BARRA DO JACARÉ	2010-03-11 00:00:00	\N	\N
3224	18	BARRACÃO	2010-03-11 00:00:00	\N	\N
3225	18	BELA VISTA DA CAROBA	2010-03-11 00:00:00	\N	\N
3226	18	BELA VISTA DO PARAÍSO	2010-03-11 00:00:00	\N	\N
3227	18	BITURUNA	2010-03-11 00:00:00	\N	\N
3228	18	BOA ESPERANÇA	2010-03-11 00:00:00	\N	\N
3229	18	BOA ESPERANÇA DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3230	18	BOA VENTURA DE SÃO ROQUE	2010-03-11 00:00:00	\N	\N
3231	18	BOA VISTA DA APARECIDA	2010-03-11 00:00:00	\N	\N
3232	18	BOCAIÚVA DO SUL	2010-03-11 00:00:00	\N	\N
3233	18	BOM JESUS DO SUL	2010-03-11 00:00:00	\N	\N
3234	18	BOM SUCESSO	2010-03-11 00:00:00	\N	\N
3235	18	BOM SUCESSO DO SUL	2010-03-11 00:00:00	\N	\N
3236	18	BORRAZÓPOLIS	2010-03-11 00:00:00	\N	\N
3237	18	BRAGANEY	2010-03-11 00:00:00	\N	\N
3238	18	BRASILÂNDIA DO SUL	2010-03-11 00:00:00	\N	\N
3239	18	CAFEARA	2010-03-11 00:00:00	\N	\N
3240	18	CAFELÂNDIA	2010-03-11 00:00:00	\N	\N
3241	18	CAFEZAL DO SUL	2010-03-11 00:00:00	\N	\N
3242	18	CALIFÓRNIA	2010-03-11 00:00:00	\N	\N
3243	18	CAMBARÁ	2010-03-11 00:00:00	\N	\N
3244	18	CAMBÉ	2010-03-11 00:00:00	\N	\N
3245	18	CAMBIRA	2010-03-11 00:00:00	\N	\N
3246	18	CAMPINA DA LAGOA	2010-03-11 00:00:00	\N	\N
3247	18	CAMPINA DO SIMÃO	2010-03-11 00:00:00	\N	\N
3248	18	CAMPINA GRANDE DO SUL	2010-03-11 00:00:00	\N	\N
3249	18	CAMPO BONITO	2010-03-11 00:00:00	\N	\N
3250	18	CAMPO DO TENENTE	2010-03-11 00:00:00	\N	\N
3251	18	CAMPO LARGO	2010-03-11 00:00:00	\N	\N
3252	18	CAMPO MAGRO	2010-03-11 00:00:00	\N	\N
3253	18	CAMPO MOURÃO	2010-03-11 00:00:00	\N	\N
3254	18	CÂNDIDO DE ABREU	2010-03-11 00:00:00	\N	\N
3255	18	CANDOI	2010-03-11 00:00:00	\N	\N
3256	18	CANTAGALO	2010-03-11 00:00:00	\N	\N
3257	18	CAPANEMA	2010-03-11 00:00:00	\N	\N
3258	18	CAPITÃO LEÔNIDAS MARQUES	2010-03-11 00:00:00	\N	\N
3259	18	CARAMBEÍ	2010-03-11 00:00:00	\N	\N
3260	18	CARLÓPOLIS	2010-03-11 00:00:00	\N	\N
3261	18	CASCAVEL	2010-03-11 00:00:00	\N	\N
3262	18	CASTRO	2010-03-11 00:00:00	\N	\N
3263	18	CATANDUVAS	2010-03-11 00:00:00	\N	\N
3264	18	CENTENÁRIO DO SUL	2010-03-11 00:00:00	\N	\N
3265	18	CÉU AZUL	2010-03-11 00:00:00	\N	\N
3266	18	CHOPINZINHO	2010-03-11 00:00:00	\N	\N
3267	18	CIANORTE	2010-03-11 00:00:00	\N	\N
3268	18	CIDADE GAÚCHA	2010-03-11 00:00:00	\N	\N
3269	18	CLEVELÂNDIA	2010-03-11 00:00:00	\N	\N
3270	18	COLOMBO	2010-03-11 00:00:00	\N	\N
3271	18	COLORADO	2010-03-11 00:00:00	\N	\N
3272	18	CONGONHINHAS	2010-03-11 00:00:00	\N	\N
3273	18	CONSELHEIRO MAIRINCK	2010-03-11 00:00:00	\N	\N
3274	18	CONTENDA	2010-03-11 00:00:00	\N	\N
3275	18	CORBÉLIA	2010-03-11 00:00:00	\N	\N
3276	18	CORNÉLIO PROCÓPIO	2010-03-11 00:00:00	\N	\N
3277	18	CORONEL DOMINGOS  SOARES	2010-03-11 00:00:00	\N	\N
3278	18	CORONEL VIVIDA	2010-03-11 00:00:00	\N	\N
3279	18	CORUMBATAÍ DO SUL	2010-03-11 00:00:00	\N	\N
3280	18	CRUZ MACHADO	2010-03-11 00:00:00	\N	\N
3281	18	CRUZEIRO DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3282	18	CRUZEIRO DO OESTE	2010-03-11 00:00:00	\N	\N
3283	18	CRUZEIRO DO SUL	2010-03-11 00:00:00	\N	\N
3284	18	CRUZMALTINA	2010-03-11 00:00:00	\N	\N
3285	18	CURITIBA	2010-03-11 00:00:00	\N	\N
3286	18	CURIUVA	2010-03-11 00:00:00	\N	\N
3287	18	DIAMANTE D OESTE	2010-03-11 00:00:00	\N	\N
3288	18	DIAMANTE DO NORTE	2010-03-11 00:00:00	\N	\N
3289	18	DIAMANTE DO SUL	2010-03-11 00:00:00	\N	\N
3290	18	DOIS VIZINHOS	2010-03-11 00:00:00	\N	\N
3291	18	DOURADINA	2010-03-11 00:00:00	\N	\N
3292	18	DOUTOR CAMARGO	2010-03-11 00:00:00	\N	\N
3293	18	DOUTOR ULYSSES	2010-03-11 00:00:00	\N	\N
3294	18	ENÉAS MARQUES	2010-03-11 00:00:00	\N	\N
3295	18	ENGENHEIRO BELTRÃO	2010-03-11 00:00:00	\N	\N
3296	18	ENTRE RIOS DO OESTE	2010-03-11 00:00:00	\N	\N
3297	18	ESPERANÇA NOVA	2010-03-11 00:00:00	\N	\N
3298	18	ESPIGÃO ALTO DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3299	18	FAROL	2010-03-11 00:00:00	\N	\N
3300	18	FAXINAL	2010-03-11 00:00:00	\N	\N
3301	18	FAZENDA RIO GRANDE	2010-03-11 00:00:00	\N	\N
3302	18	FÊNIX	2010-03-11 00:00:00	\N	\N
3303	18	FERNANDES PINHEIRO	2010-03-11 00:00:00	\N	\N
3304	18	FIGUEIRA	2010-03-11 00:00:00	\N	\N
3305	18	FLOR DA SERRA DO SUL	2010-03-11 00:00:00	\N	\N
3306	18	FLORAI	2010-03-11 00:00:00	\N	\N
3307	18	FLORESTA	2010-03-11 00:00:00	\N	\N
3308	18	FLORESTÓPOLIS	2010-03-11 00:00:00	\N	\N
3309	18	FLÓRIDA	2010-03-11 00:00:00	\N	\N
3310	18	FORMOSA DO OESTE	2010-03-11 00:00:00	\N	\N
3311	18	FOZ DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3312	18	FOZ DO JORDÃO	2010-03-11 00:00:00	\N	\N
3313	18	FRANCISCO ALVES	2010-03-11 00:00:00	\N	\N
3314	18	FRANCISCO BELTRÃO	2010-03-11 00:00:00	\N	\N
3315	18	GENERAL CARNEIRO	2010-03-11 00:00:00	\N	\N
3316	18	GODOY MOREIRA	2010-03-11 00:00:00	\N	\N
3317	18	GOIÔERE	2010-03-11 00:00:00	\N	\N
3318	18	GOIOXIM	2010-03-11 00:00:00	\N	\N
3319	18	GRANDES RIOS	2010-03-11 00:00:00	\N	\N
3320	18	GUAÍRA	2010-03-11 00:00:00	\N	\N
3321	18	GUAIRAÇA	2010-03-11 00:00:00	\N	\N
3322	18	GUAMIRANGA	2010-03-11 00:00:00	\N	\N
3323	18	GUAPIRAMA	2010-03-11 00:00:00	\N	\N
3324	18	GUAPOREMA	2010-03-11 00:00:00	\N	\N
3325	18	GUARACI	2010-03-11 00:00:00	\N	\N
3326	18	GUARANIAÇU	2010-03-11 00:00:00	\N	\N
3327	18	GUARAPUAVA	2010-03-11 00:00:00	\N	\N
3328	18	GUARAQUEÇABA	2010-03-11 00:00:00	\N	\N
3329	18	GUARATUBA	2010-03-11 00:00:00	\N	\N
3330	18	HONÓRIO SERPA	2010-03-11 00:00:00	\N	\N
3331	18	IBAITI	2010-03-11 00:00:00	\N	\N
3332	18	IBEMA	2010-03-11 00:00:00	\N	\N
3333	18	IBIPORÃ	2010-03-11 00:00:00	\N	\N
3334	18	ICARAIMA	2010-03-11 00:00:00	\N	\N
3335	18	IGUARAÇU	2010-03-11 00:00:00	\N	\N
3336	18	IGUATU	2010-03-11 00:00:00	\N	\N
3337	18	IMBAU	2010-03-11 00:00:00	\N	\N
3338	18	IMBITUVA	2010-03-11 00:00:00	\N	\N
3339	18	INÁCIO MARTINS	2010-03-11 00:00:00	\N	\N
3340	18	INAJÁ	2010-03-11 00:00:00	\N	\N
3341	18	INDIANÓPOLIS	2010-03-11 00:00:00	\N	\N
3342	18	IPIRANGA	2010-03-11 00:00:00	\N	\N
3343	18	IPORÃ	2010-03-11 00:00:00	\N	\N
3344	18	IRACEMA DO OESTE	2010-03-11 00:00:00	\N	\N
3345	18	IRATI	2010-03-11 00:00:00	\N	\N
3346	18	IRETAMA	2010-03-11 00:00:00	\N	\N
3347	18	ITAGUAJÉ	2010-03-11 00:00:00	\N	\N
3348	18	ITAIPULÂNDIA	2010-03-11 00:00:00	\N	\N
3349	18	ITAMBARACÁ	2010-03-11 00:00:00	\N	\N
3350	18	ITAMBÉ	2010-03-11 00:00:00	\N	\N
3351	18	ITAPEJARA D OESTE	2010-03-11 00:00:00	\N	\N
3352	18	ITAPERUÇU	2010-03-11 00:00:00	\N	\N
3353	18	ITAÚNA DO SUL	2010-03-11 00:00:00	\N	\N
3354	18	IVAÍ	2010-03-11 00:00:00	\N	\N
3355	18	IVAIPORÃ	2010-03-11 00:00:00	\N	\N
3356	18	IVATE	2010-03-11 00:00:00	\N	\N
3357	18	IVATUBA	2010-03-11 00:00:00	\N	\N
3358	18	JABOTI	2010-03-11 00:00:00	\N	\N
3359	18	JACAREZINHO	2010-03-11 00:00:00	\N	\N
3360	18	JAGUAPITÃ	2010-03-11 00:00:00	\N	\N
3361	18	JAGUARIAIVA	2010-03-11 00:00:00	\N	\N
3362	18	JANDAIA DO SUL	2010-03-11 00:00:00	\N	\N
3363	18	JANIÓPOLIS	2010-03-11 00:00:00	\N	\N
3364	18	JAPIRA	2010-03-11 00:00:00	\N	\N
3365	18	JAPURÁ	2010-03-11 00:00:00	\N	\N
3366	18	JARDIM ALEGRE	2010-03-11 00:00:00	\N	\N
3367	18	JARDIM OLINDA	2010-03-11 00:00:00	\N	\N
3368	18	JATAIZINHO	2010-03-11 00:00:00	\N	\N
3369	18	JESUÍTAS	2010-03-11 00:00:00	\N	\N
3370	18	JOAQUIM TÁVORA	2010-03-11 00:00:00	\N	\N
3371	18	JUNDIAÍ DO SUL	2010-03-11 00:00:00	\N	\N
3372	18	JURANDA	2010-03-11 00:00:00	\N	\N
3373	18	JUSSARA	2010-03-11 00:00:00	\N	\N
3374	18	KALORÉ	2010-03-11 00:00:00	\N	\N
3375	18	LAPA	2010-03-11 00:00:00	\N	\N
3376	18	LARANJAL	2010-03-11 00:00:00	\N	\N
3377	18	LARANJEIRAS DO SUL	2010-03-11 00:00:00	\N	\N
3378	18	LEÓPOLIS	2010-03-11 00:00:00	\N	\N
3379	18	LIDIANÓPOLIS	2010-03-11 00:00:00	\N	\N
3380	18	LINDOESTE	2010-03-11 00:00:00	\N	\N
3381	18	LOANDA	2010-03-11 00:00:00	\N	\N
3382	18	LOBATO	2010-03-11 00:00:00	\N	\N
3383	18	LONDRINA	2010-03-11 00:00:00	\N	\N
3384	18	LUIZIANA	2010-03-11 00:00:00	\N	\N
3385	18	LUNARDELLI	2010-03-11 00:00:00	\N	\N
3386	18	LUPIONÓPOLIS	2010-03-11 00:00:00	\N	\N
3387	18	MALLET	2010-03-11 00:00:00	\N	\N
3388	18	MAMBORÉ	2010-03-11 00:00:00	\N	\N
3389	18	MANDAGUAÇU	2010-03-11 00:00:00	\N	\N
3390	18	MANDAGUARI	2010-03-11 00:00:00	\N	\N
3391	18	MANDIRITUBA	2010-03-11 00:00:00	\N	\N
3392	18	MANFRINÓPOLIS	2010-03-11 00:00:00	\N	\N
3393	18	MANGUEIRINHA	2010-03-11 00:00:00	\N	\N
3394	18	MANOEL RIBAS	2010-03-11 00:00:00	\N	\N
3395	18	MARECHAL CÂNDIDO RONDON	2010-03-11 00:00:00	\N	\N
3396	18	MARIA HELENA	2010-03-11 00:00:00	\N	\N
3397	18	MARIALVA	2010-03-11 00:00:00	\N	\N
3398	18	MARILANDIA DO SUL	2010-03-11 00:00:00	\N	\N
3399	18	MARILENA	2010-03-11 00:00:00	\N	\N
3400	18	MARILUZ	2010-03-11 00:00:00	\N	\N
3401	18	MARINGÁ	2010-03-11 00:00:00	\N	\N
3402	18	MARIÓPOLIS	2010-03-11 00:00:00	\N	\N
3403	18	MARIPÁ	2010-03-11 00:00:00	\N	\N
3404	18	MARMELEIRO	2010-03-11 00:00:00	\N	\N
3405	18	MARQUINHO	2010-03-11 00:00:00	\N	\N
3406	18	MARUMBI	2010-03-11 00:00:00	\N	\N
3407	18	MATELÂNDIA	2010-03-11 00:00:00	\N	\N
3408	18	MATINHOS	2010-03-11 00:00:00	\N	\N
3409	18	MATO RICO	2010-03-11 00:00:00	\N	\N
3410	18	MAUÁ DA SERRA	2010-03-11 00:00:00	\N	\N
3411	18	MEDIANEIRA	2010-03-11 00:00:00	\N	\N
3412	18	MERCEDES	2010-03-11 00:00:00	\N	\N
3413	18	MIRADOR	2010-03-11 00:00:00	\N	\N
3414	18	MIRASELVA	2010-03-11 00:00:00	\N	\N
3415	18	MISSAL	2010-03-11 00:00:00	\N	\N
3416	18	MOREIRA SALES	2010-03-11 00:00:00	\N	\N
3417	18	MORRETES	2010-03-11 00:00:00	\N	\N
3418	18	MUNHOZ DE MELO	2010-03-11 00:00:00	\N	\N
3419	18	NOSSA SENHORA DAS GRAÇAS	2010-03-11 00:00:00	\N	\N
3420	18	NOVA ALIANÇA DO IVAÍ	2010-03-11 00:00:00	\N	\N
3421	18	NOVA AMÉRICA DA COLINA	2010-03-11 00:00:00	\N	\N
3422	18	NOVA AURORA	2010-03-11 00:00:00	\N	\N
3423	18	NOVA CANTU	2010-03-11 00:00:00	\N	\N
3424	18	NOVA ESPERANÇA	2010-03-11 00:00:00	\N	\N
3425	18	NOVA ESPERANÇA DO SUDOESTE	2010-03-11 00:00:00	\N	\N
3426	18	NOVA FÁTIMA	2010-03-11 00:00:00	\N	\N
3427	18	NOVA LARANJEIRAS	2010-03-11 00:00:00	\N	\N
3428	18	NOVA LONDRINA	2010-03-11 00:00:00	\N	\N
3429	18	NOVA OLÍMPIA	2010-03-11 00:00:00	\N	\N
3430	18	NOVA PRATA DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3431	18	NOVA SANTA BÁRBARA	2010-03-11 00:00:00	\N	\N
3432	18	NOVA SANTA ROSA	2010-03-11 00:00:00	\N	\N
3433	18	NOVA TEBAS	2010-03-11 00:00:00	\N	\N
3434	18	NOVO ITACOLOMI	2010-03-11 00:00:00	\N	\N
3435	18	ORTIGUEIRA	2010-03-11 00:00:00	\N	\N
3436	18	OURIZONA	2010-03-11 00:00:00	\N	\N
3437	18	OURO VERDE DO OESTE	2010-03-11 00:00:00	\N	\N
3438	18	PAIÇANDU	2010-03-11 00:00:00	\N	\N
3439	18	PALMAS	2010-03-11 00:00:00	\N	\N
3440	18	PALMEIRA	2010-03-11 00:00:00	\N	\N
3441	18	PALMITAL	2010-03-11 00:00:00	\N	\N
3442	18	PALOTINA	2010-03-11 00:00:00	\N	\N
3443	18	PARAÍSO DO NORTE	2010-03-11 00:00:00	\N	\N
3444	18	PARANACITY	2010-03-11 00:00:00	\N	\N
3445	18	PARANAGUÁ	2010-03-11 00:00:00	\N	\N
3446	18	PARANAPOEMA	2010-03-11 00:00:00	\N	\N
3447	18	PARANAVAÍ	2010-03-11 00:00:00	\N	\N
3448	18	PATO BRAGADO	2010-03-11 00:00:00	\N	\N
3449	18	PATO BRANCO	2010-03-11 00:00:00	\N	\N
3450	18	PAULA FREITAS	2010-03-11 00:00:00	\N	\N
3451	18	PAULO FRONTIN	2010-03-11 00:00:00	\N	\N
3452	18	PEABIRU	2010-03-11 00:00:00	\N	\N
3453	18	PEROBAL	2010-03-11 00:00:00	\N	\N
3454	18	PÉROLA	2010-03-11 00:00:00	\N	\N
3455	18	PÉROLA D OESTE	2010-03-11 00:00:00	\N	\N
3456	18	PIEN	2010-03-11 00:00:00	\N	\N
3457	18	PINHAIS	2010-03-11 00:00:00	\N	\N
3458	18	PINHAL DE SÃO BENTO	2010-03-11 00:00:00	\N	\N
3459	18	PINHALÃO	2010-03-11 00:00:00	\N	\N
3460	18	PINHÃO	2010-03-11 00:00:00	\N	\N
3461	18	PIRAÍ DO SUL	2010-03-11 00:00:00	\N	\N
3462	18	PIRAQUARA	2010-03-11 00:00:00	\N	\N
3463	18	PITANGA	2010-03-11 00:00:00	\N	\N
3464	18	PITANGUEIRAS	2010-03-11 00:00:00	\N	\N
3465	18	PLANALTINA DO PARANÁ	2010-03-11 00:00:00	\N	\N
3466	18	PLANALTO	2010-03-11 00:00:00	\N	\N
3467	18	PONTA GROSSA	2010-03-11 00:00:00	\N	\N
3468	18	PONTAL DO PARANÁ	2010-03-11 00:00:00	\N	\N
3469	18	PORECATU	2010-03-11 00:00:00	\N	\N
3470	18	PORTO AMAZONAS	2010-03-11 00:00:00	\N	\N
3471	18	PORTO BARREIRO	2010-03-11 00:00:00	\N	\N
3472	18	PORTO RICO	2010-03-11 00:00:00	\N	\N
3473	18	PORTO VITÓRIA	2010-03-11 00:00:00	\N	\N
3474	18	PRADO FERREIRA	2010-03-11 00:00:00	\N	\N
3475	18	PRANCHITA	2010-03-11 00:00:00	\N	\N
3476	18	PRESIDENTE CASTELO BRANCO	2010-03-11 00:00:00	\N	\N
3477	18	PRIMEIRO DE MAIO	2010-03-11 00:00:00	\N	\N
3478	18	PRUDENTÓPOLIS	2010-03-11 00:00:00	\N	\N
3479	18	QUARTO CENTENÁRIO	2010-03-11 00:00:00	\N	\N
3480	18	QUATIGUÁ	2010-03-11 00:00:00	\N	\N
3481	18	QUATRO BARRAS	2010-03-11 00:00:00	\N	\N
3482	18	QUATRO PONTES	2010-03-11 00:00:00	\N	\N
3483	18	QUEDAS DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3484	18	QUERÊNCIA DO NORTE	2010-03-11 00:00:00	\N	\N
3485	18	QUINTA DO SOL	2010-03-11 00:00:00	\N	\N
3486	18	QUITANDINHA	2010-03-11 00:00:00	\N	\N
3487	18	RAMILÂNDIA	2010-03-11 00:00:00	\N	\N
3488	18	RANCHO ALEGRE	2010-03-11 00:00:00	\N	\N
3489	18	RANCHO ALEGRE D OESTE	2010-03-11 00:00:00	\N	\N
3490	18	REALEZA	2010-03-11 00:00:00	\N	\N
3491	18	REBOUÇAS	2010-03-11 00:00:00	\N	\N
3492	18	RENASCENÇA	2010-03-11 00:00:00	\N	\N
3493	18	RESERVA	2010-03-11 00:00:00	\N	\N
3494	18	RESERVA DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3495	18	RIBEIRÃO CLARO	2010-03-11 00:00:00	\N	\N
3496	18	RIBEIRÃO DO PINHAL	2010-03-11 00:00:00	\N	\N
3497	18	RIO AZUL	2010-03-11 00:00:00	\N	\N
3498	18	RIO BOM	2010-03-11 00:00:00	\N	\N
3499	18	RIO BONITO DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3500	18	RIO BRANCO DO IVAÍ	2010-03-11 00:00:00	\N	\N
3501	18	RIO BRANCO DO SUL	2010-03-11 00:00:00	\N	\N
3502	18	RIO NEGRO	2010-03-11 00:00:00	\N	\N
3503	18	ROLÂNDIA	2010-03-11 00:00:00	\N	\N
3504	18	RONCADOR	2010-03-11 00:00:00	\N	\N
3505	18	RONDON	2010-03-11 00:00:00	\N	\N
3506	18	ROSÁRIO DO IVAÍ	2010-03-11 00:00:00	\N	\N
3507	18	SABAUDIA	2010-03-11 00:00:00	\N	\N
3508	18	SALGADO FILHO	2010-03-11 00:00:00	\N	\N
3509	18	SALTO DO ITARARÉ	2010-03-11 00:00:00	\N	\N
3510	18	SALTO DO LONTRA	2010-03-11 00:00:00	\N	\N
3511	18	SANTA AMÉLIA	2010-03-11 00:00:00	\N	\N
3512	18	SANTA CECÍLIA DO PAVÃO	2010-03-11 00:00:00	\N	\N
3513	18	SANTA CRUZ DE MONTE CASTELO	2010-03-11 00:00:00	\N	\N
3514	18	SANTA FÉ	2010-03-11 00:00:00	\N	\N
3515	18	SANTA HELENA	2010-03-11 00:00:00	\N	\N
3516	18	SANTA INÊS	2010-03-11 00:00:00	\N	\N
3517	18	SANTA ISABEL DO IVAÍ	2010-03-11 00:00:00	\N	\N
3518	18	SANTA IZABEL DO OESTE	2010-03-11 00:00:00	\N	\N
3519	18	SANTA LÚCIA	2010-03-11 00:00:00	\N	\N
3520	18	SANTA MARIA DO OESTE	2010-03-11 00:00:00	\N	\N
3521	18	SANTA MARIANA	2010-03-11 00:00:00	\N	\N
3522	18	SANTA MÔNICA	2010-03-11 00:00:00	\N	\N
3523	18	SANTA TEREZA DO OESTE	2010-03-11 00:00:00	\N	\N
3524	18	SANTA TEREZINHA DE ITAIPU	2010-03-11 00:00:00	\N	\N
3525	18	SANTANA DO ITARARÉ	2010-03-11 00:00:00	\N	\N
3526	18	SANTO ANTÔNIO DA PLATINA	2010-03-11 00:00:00	\N	\N
3527	18	SANTO ANTÔNIO DO CAIUÁ	2010-03-11 00:00:00	\N	\N
3528	18	SANTO ANTÔNIO DO PARAÍSO	2010-03-11 00:00:00	\N	\N
3529	18	SANTO ANTÔNIO DO SUDOESTE	2010-03-11 00:00:00	\N	\N
3530	18	SANTO INÁCIO	2010-03-11 00:00:00	\N	\N
3531	18	SÃO CARLOS DO IVAÍ	2010-03-11 00:00:00	\N	\N
3532	18	SÃO JERÔNIMO DA SERRA	2010-03-11 00:00:00	\N	\N
3533	18	SÃO JOÃO	2010-03-11 00:00:00	\N	\N
3534	18	SÃO JOÃO DO CAIUÁ	2010-03-11 00:00:00	\N	\N
3535	18	SÃO JOÃO DO IVAÍ	2010-03-11 00:00:00	\N	\N
3536	18	SÃO JOÃO DO TRIUNFO	2010-03-11 00:00:00	\N	\N
3537	18	SÃO JORGE D OESTE	2010-03-11 00:00:00	\N	\N
3538	18	SÃO JORGE DO IVAÍ	2010-03-11 00:00:00	\N	\N
3539	18	SÃO JORGE DO PATROCÍNIO	2010-03-11 00:00:00	\N	\N
3540	18	SÃO JOSÉ DA BOA VISTA	2010-03-11 00:00:00	\N	\N
3541	18	SÃO JOSÉ DAS PALMEIRAS	2010-03-11 00:00:00	\N	\N
3542	18	SÃO JOSÉ DOS PINHAIS	2010-03-11 00:00:00	\N	\N
3543	18	SÃO MANOEL DO PARANÁ	2010-03-11 00:00:00	\N	\N
3544	18	SÃO MATEUS DO SUL	2010-03-11 00:00:00	\N	\N
3545	18	SÃO MIGUEL DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3546	18	SÃO PEDRO DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3547	18	SÃO PEDRO DO IVAÍ	2010-03-11 00:00:00	\N	\N
3548	18	SÃO PEDRO DO PARANÁ	2010-03-11 00:00:00	\N	\N
3549	18	SÃO SEBASTIÃO DA AMOREIRA	2010-03-11 00:00:00	\N	\N
3550	18	SÃO TOMÉ	2010-03-11 00:00:00	\N	\N
3551	18	SAPOPEMA	2010-03-11 00:00:00	\N	\N
3552	18	SARANDI	2010-03-11 00:00:00	\N	\N
3553	18	SAUDADE DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3554	18	SENGES	2010-03-11 00:00:00	\N	\N
3555	18	SERRANÓPOLIS DO IGUAÇU	2010-03-11 00:00:00	\N	\N
3556	18	SERRO AZUL	2010-03-11 00:00:00	\N	\N
3557	18	SERTANEJA	2010-03-11 00:00:00	\N	\N
3558	18	SERTANÓPOLIS	2010-03-11 00:00:00	\N	\N
3559	18	SIQUEIRA CAMPOS	2010-03-11 00:00:00	\N	\N
3560	18	SULINA	2010-03-11 00:00:00	\N	\N
3561	18	TAMARANA	2010-03-11 00:00:00	\N	\N
3562	18	TAMBOARA	2010-03-11 00:00:00	\N	\N
3563	18	TAPEJARA	2010-03-11 00:00:00	\N	\N
3564	18	TAPIRA	2010-03-11 00:00:00	\N	\N
3565	18	TEIXEIRA SOARES	2010-03-11 00:00:00	\N	\N
3566	18	TELÊMACO BORBA	2010-03-11 00:00:00	\N	\N
3567	18	TERRA BOA	2010-03-11 00:00:00	\N	\N
3568	18	TERRA RICA	2010-03-11 00:00:00	\N	\N
3569	18	TERRA ROXA	2010-03-11 00:00:00	\N	\N
3570	18	TIBAGI	2010-03-11 00:00:00	\N	\N
3571	18	TIJUCAS DO SUL	2010-03-11 00:00:00	\N	\N
3572	18	TOLEDO	2010-03-11 00:00:00	\N	\N
3573	18	TOMAZINA	2010-03-11 00:00:00	\N	\N
3574	18	TRÊS BARRAS DO PARANÁ	2010-03-11 00:00:00	\N	\N
3575	18	TUNAS DO PARANÁ	2010-03-11 00:00:00	\N	\N
3576	18	TUNEIRAS DO OESTE	2010-03-11 00:00:00	\N	\N
3577	18	TUPÃSSI	2010-03-11 00:00:00	\N	\N
3578	18	TURVO	2010-03-11 00:00:00	\N	\N
3579	18	UBIRATÃ	2010-03-11 00:00:00	\N	\N
3580	18	UMUARAMA	2010-03-11 00:00:00	\N	\N
3581	18	UNIÃO DA VITÓRIA	2010-03-11 00:00:00	\N	\N
3582	18	UNIFLOR	2010-03-11 00:00:00	\N	\N
3583	18	URAÍ	2010-03-11 00:00:00	\N	\N
3584	18	VENTANIA	2010-03-11 00:00:00	\N	\N
3585	18	VERA CRUZ DO OESTE	2010-03-11 00:00:00	\N	\N
3586	18	VERE	2010-03-11 00:00:00	\N	\N
3587	18	VIRMOND	2010-03-11 00:00:00	\N	\N
3588	18	VITORINO	2010-03-11 00:00:00	\N	\N
3589	18	WENCESLAU BRAZ	2010-03-11 00:00:00	\N	\N
3590	18	XAMBRE	2010-03-11 00:00:00	\N	\N
3591	19	ANGRA DOS REIS	2010-03-11 00:00:00	\N	\N
3592	19	APERIBÉ	2010-03-11 00:00:00	\N	\N
3593	19	ARARUAMA	2010-03-11 00:00:00	\N	\N
3594	19	AREAL	2010-03-11 00:00:00	\N	\N
3595	19	ARMAÇÃO DE BÚZIOS	2010-03-11 00:00:00	\N	\N
3596	19	ARRAIAL DO CABO	2010-03-11 00:00:00	\N	\N
3597	19	BARRA DO PIRAÍ	2010-03-11 00:00:00	\N	\N
3598	19	BARRA MANSA	2010-03-11 00:00:00	\N	\N
3599	19	BELFORD ROXO	2010-03-11 00:00:00	\N	\N
3600	19	BOM JARDIM	2010-03-11 00:00:00	\N	\N
3601	19	BOM JESUS DO ITABAPOANA	2010-03-11 00:00:00	\N	\N
3602	19	CABO FRIO	2010-03-11 00:00:00	\N	\N
3603	19	CACHOEIRAS DE MACACU	2010-03-11 00:00:00	\N	\N
3604	19	CAMBUCI	2010-03-11 00:00:00	\N	\N
3605	19	CAMPOS DOS GOYTACAZES	2010-03-11 00:00:00	\N	\N
3606	19	CANTAGALO	2010-03-11 00:00:00	\N	\N
3607	19	CARAPEBUS	2010-03-11 00:00:00	\N	\N
3608	19	CARDOSO MOREIRA	2010-03-11 00:00:00	\N	\N
3609	19	CARMO	2010-03-11 00:00:00	\N	\N
3610	19	CASIMIRO DE ABREU	2010-03-11 00:00:00	\N	\N
3611	19	COMENDADOR LEVY GASPARIAN	2010-03-11 00:00:00	\N	\N
3612	19	CONCEIÇÃO DE MACABU	2010-03-11 00:00:00	\N	\N
3613	19	CORDEIRO	2010-03-11 00:00:00	\N	\N
3614	19	DUAS BARRAS	2010-03-11 00:00:00	\N	\N
3615	19	DUQUE DE CAXIAS	2010-03-11 00:00:00	\N	\N
3616	19	ENGENHEIRO PAULO DE FRONTIN	2010-03-11 00:00:00	\N	\N
3617	19	GUAPIMIRIM	2010-03-11 00:00:00	\N	\N
3618	19	IGUABA GRANDE	2010-03-11 00:00:00	\N	\N
3619	19	ITABORAÍ	2010-03-11 00:00:00	\N	\N
3620	19	ITAGUAÍ	2010-03-11 00:00:00	\N	\N
3621	19	ITALVA	2010-03-11 00:00:00	\N	\N
3622	19	ITAOCARA	2010-03-11 00:00:00	\N	\N
3623	19	ITAPERUNA	2010-03-11 00:00:00	\N	\N
3624	19	ITATIAIA	2010-03-11 00:00:00	\N	\N
3625	19	JAPERI	2010-03-11 00:00:00	\N	\N
3626	19	LAJE DO MURIAÉ	2010-03-11 00:00:00	\N	\N
3627	19	MACAÉ	2010-03-11 00:00:00	\N	\N
3628	19	MACUCO	2010-03-11 00:00:00	\N	\N
3629	19	MAGÉ	2010-03-11 00:00:00	\N	\N
3630	19	MANGARATIBA	2010-03-11 00:00:00	\N	\N
3631	19	MARICÁ	2010-03-11 00:00:00	\N	\N
3632	19	MENDES	2010-03-11 00:00:00	\N	\N
3633	19	MESQUITA	2010-03-11 00:00:00	\N	\N
3634	19	MIGUEL PEREIRA	2010-03-11 00:00:00	\N	\N
3635	19	MIRACEMA	2010-03-11 00:00:00	\N	\N
3636	19	NATIVIDADE	2010-03-11 00:00:00	\N	\N
3637	19	NILÓPOLIS	2010-03-11 00:00:00	\N	\N
3638	19	NITERÓI	2010-03-11 00:00:00	\N	\N
3639	19	NOVA FRIBURGO	2010-03-11 00:00:00	\N	\N
3640	19	NOVA IGUAÇU	2010-03-11 00:00:00	\N	\N
3641	19	PARACAMBI	2010-03-11 00:00:00	\N	\N
3642	19	PARAÍBA DO SUL	2010-03-11 00:00:00	\N	\N
3643	19	PARATI	2010-03-11 00:00:00	\N	\N
3644	19	PATY DO ALFERES	2010-03-11 00:00:00	\N	\N
3645	19	PETRÓPOLIS	2010-03-11 00:00:00	\N	\N
3646	19	PINHEIRAL	2010-03-11 00:00:00	\N	\N
3647	19	PIRAÍ	2010-03-11 00:00:00	\N	\N
3648	19	PORCIÚNCULA	2010-03-11 00:00:00	\N	\N
3649	19	PORTO REAL	2010-03-11 00:00:00	\N	\N
3650	19	QUATIS	2010-03-11 00:00:00	\N	\N
3651	19	QUEIMADOS	2010-03-11 00:00:00	\N	\N
3652	19	QUISSAMÃ	2010-03-11 00:00:00	\N	\N
3653	19	RESENDE	2010-03-11 00:00:00	\N	\N
3654	19	RIO BONITO	2010-03-11 00:00:00	\N	\N
3655	19	RIO CLARO	2010-03-11 00:00:00	\N	\N
3656	19	RIO DAS FLORES	2010-03-11 00:00:00	\N	\N
3657	19	RIO DAS OSTRAS	2010-03-11 00:00:00	\N	\N
3658	19	RIO DE JANEIRO	2010-03-11 00:00:00	\N	\N
3659	19	SANTA MARIA MADALENA	2010-03-11 00:00:00	\N	\N
3660	19	SANTO ANTÔNIO DE PÁDUA	2010-03-11 00:00:00	\N	\N
3661	19	SÃO FIDÉLIS	2010-03-11 00:00:00	\N	\N
3662	19	SÃO FRANCISCO DE ITABAPOANA	2010-03-11 00:00:00	\N	\N
3663	19	SÃO GONÇALO	2010-03-11 00:00:00	\N	\N
3664	19	SÃO JOÃO DA BARRA	2010-03-11 00:00:00	\N	\N
3665	19	SÃO JOÃO DE MERITI	2010-03-11 00:00:00	\N	\N
3666	19	SÃO JOSÉ DE UBÁ	2010-03-11 00:00:00	\N	\N
3667	19	SÃO JOSÉ DO VALE DO RIO PRETO	2010-03-11 00:00:00	\N	\N
3668	19	SÃO PEDRO DA ALDEIA	2010-03-11 00:00:00	\N	\N
3669	19	SÃO SEBASTIÃO DO ALTO	2010-03-11 00:00:00	\N	\N
3670	19	SAPUCAIA	2010-03-11 00:00:00	\N	\N
3671	19	SAQUAREMA	2010-03-11 00:00:00	\N	\N
3672	19	SEROPÉDICA	2010-03-11 00:00:00	\N	\N
3673	19	SILVA JARDIM	2010-03-11 00:00:00	\N	\N
3674	19	SUMIDOURO	2010-03-11 00:00:00	\N	\N
3675	19	TANGUÁ	2010-03-11 00:00:00	\N	\N
3676	19	TERESÓPOLIS	2010-03-11 00:00:00	\N	\N
3677	19	TRAJANO DE MORAIS	2010-03-11 00:00:00	\N	\N
3678	19	TRÊS RIOS	2010-03-11 00:00:00	\N	\N
3679	19	VALENÇA	2010-03-11 00:00:00	\N	\N
3680	19	VARRE E SAI	2010-03-11 00:00:00	\N	\N
3681	19	VASSOURAS	2010-03-11 00:00:00	\N	\N
3682	19	VOLTA REDONDA	2010-03-11 00:00:00	\N	\N
3683	20	ACARI	2010-03-11 00:00:00	\N	\N
3684	20	AÇU	2010-03-11 00:00:00	\N	\N
3685	20	AFONSO BEZERRA	2010-03-11 00:00:00	\N	\N
3686	20	ÁGUA NOVA	2010-03-11 00:00:00	\N	\N
3687	20	ALEXANDRIA	2010-03-11 00:00:00	\N	\N
3688	20	ALMINO AFONSO	2010-03-11 00:00:00	\N	\N
3689	20	ALTO DOS RODRIGUES	2010-03-11 00:00:00	\N	\N
3690	20	ANGICOS	2010-03-11 00:00:00	\N	\N
3691	20	ANTÔNIO MARTINS	2010-03-11 00:00:00	\N	\N
3692	20	APODI	2010-03-11 00:00:00	\N	\N
3693	20	AREIA BRANCA	2010-03-11 00:00:00	\N	\N
3694	20	ARES	2010-03-11 00:00:00	\N	\N
3695	20	AUGUSTO SEVERO	2010-03-11 00:00:00	\N	\N
3696	20	BAÍA FORMOSA	2010-03-11 00:00:00	\N	\N
3697	20	BARAÚNA	2010-03-11 00:00:00	\N	\N
3698	20	BARCELONA	2010-03-11 00:00:00	\N	\N
3699	20	BENTO FERNANDES	2010-03-11 00:00:00	\N	\N
3700	20	BODÓ	2010-03-11 00:00:00	\N	\N
3701	20	BOM JESUS	2010-03-11 00:00:00	\N	\N
3702	20	BREJINHO	2010-03-11 00:00:00	\N	\N
3703	20	CAIÇARA DO NORTE	2010-03-11 00:00:00	\N	\N
3704	20	CAIÇARA DO RIO DO VENTO	2010-03-11 00:00:00	\N	\N
3705	20	CAICÓ	2010-03-11 00:00:00	\N	\N
3706	20	CAMPO REDONDO	2010-03-11 00:00:00	\N	\N
3707	20	CANGUARETAMA	2010-03-11 00:00:00	\N	\N
3708	20	CARAÚBAS	2010-03-11 00:00:00	\N	\N
3709	20	CARNAÚBA DOS DANTAS	2010-03-11 00:00:00	\N	\N
3710	20	CARNAUBAIS	2010-03-11 00:00:00	\N	\N
3711	20	CEARÁ-MIRIM	2010-03-11 00:00:00	\N	\N
3712	20	CERRO CORÁ	2010-03-11 00:00:00	\N	\N
3713	20	CORONEL EZEQUIEL	2010-03-11 00:00:00	\N	\N
3714	20	CORONEL JOÃO PESSOA	2010-03-11 00:00:00	\N	\N
3715	20	CRUZETA	2010-03-11 00:00:00	\N	\N
3716	20	CURRAIS NOVOS	2010-03-11 00:00:00	\N	\N
3717	20	DOUTOR SEVERIANO	2010-03-11 00:00:00	\N	\N
3718	20	ENCANTO	2010-03-11 00:00:00	\N	\N
3719	20	EQUADOR	2010-03-11 00:00:00	\N	\N
3720	20	ESPÍRITO SANTO	2010-03-11 00:00:00	\N	\N
3721	20	EXTREMOZ	2010-03-11 00:00:00	\N	\N
3722	20	FELIPE GUERRA	2010-03-11 00:00:00	\N	\N
3723	20	FERNANDO PEDROZA	2010-03-11 00:00:00	\N	\N
3724	20	FLORÂNIA	2010-03-11 00:00:00	\N	\N
3725	20	FRANCISCO DANTAS	2010-03-11 00:00:00	\N	\N
3726	20	FRUTUOSO GOMES	2010-03-11 00:00:00	\N	\N
3727	20	GALINHOS	2010-03-11 00:00:00	\N	\N
3728	20	GOIANINHA	2010-03-11 00:00:00	\N	\N
3729	20	GOVERNADOR DIX-SEPT ROSADO	2010-03-11 00:00:00	\N	\N
3730	20	GROSSOS	2010-03-11 00:00:00	\N	\N
3731	20	GUAMARE	2010-03-11 00:00:00	\N	\N
3732	20	IELMO MARINHO	2010-03-11 00:00:00	\N	\N
3733	20	IPANGUAÇU	2010-03-11 00:00:00	\N	\N
3734	20	IPUEIRA	2010-03-11 00:00:00	\N	\N
3735	20	ITAJÁ	2010-03-11 00:00:00	\N	\N
3736	20	ITAÚ	2010-03-11 00:00:00	\N	\N
3737	20	JAÇANÃ	2010-03-11 00:00:00	\N	\N
3738	20	JANDAÍRA	2010-03-11 00:00:00	\N	\N
3739	20	JANDUÍS	2010-03-11 00:00:00	\N	\N
3740	20	JANUÁRIO CICCO	2010-03-11 00:00:00	\N	\N
3741	20	JAPI	2010-03-11 00:00:00	\N	\N
3742	20	JARDIM DE ANGICOS	2010-03-11 00:00:00	\N	\N
3743	20	JARDIM DE PIRANHAS	2010-03-11 00:00:00	\N	\N
3744	20	JARDIM DO SERIDÓ	2010-03-11 00:00:00	\N	\N
3745	20	JOÃO CÂMARA	2010-03-11 00:00:00	\N	\N
3746	20	JOÃO DIAS	2010-03-11 00:00:00	\N	\N
3747	20	JOSÉ DA PENHA	2010-03-11 00:00:00	\N	\N
3748	20	JUCURUTU	2010-03-11 00:00:00	\N	\N
3749	20	JUNDIÁ	2010-03-11 00:00:00	\N	\N
3750	20	LAGOA D ANTA	2010-03-11 00:00:00	\N	\N
3751	20	LAGOA DE PEDRAS	2010-03-11 00:00:00	\N	\N
3752	20	LAGOA DE VELHOS	2010-03-11 00:00:00	\N	\N
3753	20	LAGOA NOVA	2010-03-11 00:00:00	\N	\N
3754	20	LAGOA SALGADA	2010-03-11 00:00:00	\N	\N
3755	20	LAJES	2010-03-11 00:00:00	\N	\N
3756	20	LAJES PINTADAS	2010-03-11 00:00:00	\N	\N
3757	20	LUCRÉCIA	2010-03-11 00:00:00	\N	\N
3758	20	LUIS GOMES	2010-03-11 00:00:00	\N	\N
3759	20	MACAIBA	2010-03-11 00:00:00	\N	\N
3760	20	MACAU	2010-03-11 00:00:00	\N	\N
3761	20	MAJOR SALES	2010-03-11 00:00:00	\N	\N
3762	20	MARCELINO VIEIRA	2010-03-11 00:00:00	\N	\N
3763	20	MARTINS	2010-03-11 00:00:00	\N	\N
3764	20	MAXARANGUAPE	2010-03-11 00:00:00	\N	\N
3765	20	MESSIAS TARGINO	2010-03-11 00:00:00	\N	\N
3766	20	MONTANHAS	2010-03-11 00:00:00	\N	\N
3767	20	MONTE ALEGRE	2010-03-11 00:00:00	\N	\N
3768	20	MONTE DAS GAMELEIRAS	2010-03-11 00:00:00	\N	\N
3769	20	MOSSORÓ	2010-03-11 00:00:00	\N	\N
3770	20	NATAL	2010-03-11 00:00:00	\N	\N
3771	20	NISIA FLORESTA	2010-03-11 00:00:00	\N	\N
3772	20	NOVA CRUZ	2010-03-11 00:00:00	\N	\N
3773	20	OLHO D ÁGUA DO BORGES	2010-03-11 00:00:00	\N	\N
3774	20	OURO BRANCO	2010-03-11 00:00:00	\N	\N
3775	20	PARANÁ	2010-03-11 00:00:00	\N	\N
3776	20	PARAU	2010-03-11 00:00:00	\N	\N
3777	20	PARAZINHO	2010-03-11 00:00:00	\N	\N
3778	20	PARELHAS	2010-03-11 00:00:00	\N	\N
3779	20	PARNAMIRIM	2010-03-11 00:00:00	\N	\N
3780	20	PASSA E FICA	2010-03-11 00:00:00	\N	\N
3781	20	PASSAGEM	2010-03-11 00:00:00	\N	\N
3782	20	PATU	2010-03-11 00:00:00	\N	\N
3783	20	PAU DOS FERROS	2010-03-11 00:00:00	\N	\N
3784	20	PEDRA GRANDE	2010-03-11 00:00:00	\N	\N
3785	20	PEDRA PRETA	2010-03-11 00:00:00	\N	\N
3786	20	PEDRO AVELINO	2010-03-11 00:00:00	\N	\N
3787	20	PEDRO VELHO	2010-03-11 00:00:00	\N	\N
3788	20	PENDÊNCIAS	2010-03-11 00:00:00	\N	\N
3789	20	PILÕES	2010-03-11 00:00:00	\N	\N
3790	20	POÇO BRANCO	2010-03-11 00:00:00	\N	\N
3791	20	PORTALEGRE	2010-03-11 00:00:00	\N	\N
3792	20	PORTO DO MANGUE	2010-03-11 00:00:00	\N	\N
3793	20	PRESIDENTE JUSCELINO	2010-03-11 00:00:00	\N	\N
3794	20	PUREZA	2010-03-11 00:00:00	\N	\N
3795	20	RAFAEL FERNANDES	2010-03-11 00:00:00	\N	\N
3796	20	RAFAEL GODEIRO	2010-03-11 00:00:00	\N	\N
3797	20	RIACHO DA CRUZ	2010-03-11 00:00:00	\N	\N
3798	20	RIACHO DE SANTANA	2010-03-11 00:00:00	\N	\N
3799	20	RIACHUELO	2010-03-11 00:00:00	\N	\N
3800	20	RIO DO FOGO	2010-03-11 00:00:00	\N	\N
3801	20	RODOLFO FERNANDES	2010-03-11 00:00:00	\N	\N
3802	20	RUY BARBOSA	2010-03-11 00:00:00	\N	\N
3803	20	SANTA CRUZ	2010-03-11 00:00:00	\N	\N
3804	20	SANTA MARIA	2010-03-11 00:00:00	\N	\N
3805	20	SANTANA DO MATOS	2010-03-11 00:00:00	\N	\N
3806	20	SANTANA DO SERIDÓ	2010-03-11 00:00:00	\N	\N
3807	20	SANTO ANTÔNIO	2010-03-11 00:00:00	\N	\N
3808	20	SÃO BENTO DO NORTE	2010-03-11 00:00:00	\N	\N
3809	20	SÃO BENTO DO TRAIRI	2010-03-11 00:00:00	\N	\N
3810	20	SÃO FERNANDO	2010-03-11 00:00:00	\N	\N
3811	20	SÃO FRANCISCO DO OESTE	2010-03-11 00:00:00	\N	\N
3812	20	SÃO GONÇALO DO AMARANTE	2010-03-11 00:00:00	\N	\N
3813	20	SÃO JOÃO DO SABUGI	2010-03-11 00:00:00	\N	\N
3814	20	SÃO JOSÉ DE MIPIBU	2010-03-11 00:00:00	\N	\N
3815	20	SÃO JOSÉ DO CAMPESTRE	2010-03-11 00:00:00	\N	\N
3816	20	SÃO JOSÉ DO SERIDÓ	2010-03-11 00:00:00	\N	\N
3817	20	SÃO MIGUEL	2010-03-11 00:00:00	\N	\N
3818	20	SÃO MIGUEL DO GOSTOSO	2010-03-11 00:00:00	\N	\N
3819	20	SÃO PAULO DO POTENGI	2010-03-11 00:00:00	\N	\N
3820	20	SÃO PEDRO	2010-03-11 00:00:00	\N	\N
3821	20	SÃO RAFAEL	2010-03-11 00:00:00	\N	\N
3822	20	SÃO TOMÉ	2010-03-11 00:00:00	\N	\N
3823	20	SÃO VICENTE	2010-03-11 00:00:00	\N	\N
3824	20	SENADOR ELÓI DE SOUZA	2010-03-11 00:00:00	\N	\N
3825	20	SENADOR GEORGINO AVELINO	2010-03-11 00:00:00	\N	\N
3826	20	SERRA DE SÃO BENTO	2010-03-11 00:00:00	\N	\N
3827	20	SERRA DO MEL	2010-03-11 00:00:00	\N	\N
3828	20	SERRA NEGRA DO NORTE	2010-03-11 00:00:00	\N	\N
3829	20	SERRINHA	2010-03-11 00:00:00	\N	\N
3830	20	SERRINHA DOS PINTOS	2010-03-11 00:00:00	\N	\N
3831	20	SEVERIANO MELO	2010-03-11 00:00:00	\N	\N
3832	20	SÍTIO NOVO	2010-03-11 00:00:00	\N	\N
3833	20	TABOLEIRO GRANDE	2010-03-11 00:00:00	\N	\N
3834	20	TAIPU	2010-03-11 00:00:00	\N	\N
3835	20	TANGARÁ	2010-03-11 00:00:00	\N	\N
3836	20	TENENTE ANANIAS	2010-03-11 00:00:00	\N	\N
3837	20	TENENTE LAURENTINO CRUZ	2010-03-11 00:00:00	\N	\N
3838	20	TIBAU	2010-03-11 00:00:00	\N	\N
3839	20	TIBAU DO SUL	2010-03-11 00:00:00	\N	\N
3840	20	TIMBAÚBA DOS BATISTAS	2010-03-11 00:00:00	\N	\N
3841	20	TOUROS	2010-03-11 00:00:00	\N	\N
3842	20	TRIUNFO POTIGUAR	2010-03-11 00:00:00	\N	\N
3843	20	UMARIZAL	2010-03-11 00:00:00	\N	\N
3844	20	UPANEMA	2010-03-11 00:00:00	\N	\N
3845	20	VÁRZEA	2010-03-11 00:00:00	\N	\N
3846	20	VENHA-VER	2010-03-11 00:00:00	\N	\N
3847	20	VERA CRUZ	2010-03-11 00:00:00	\N	\N
3848	20	VIÇOSA	2010-03-11 00:00:00	\N	\N
3849	20	VILA FLOR	2010-03-11 00:00:00	\N	\N
3850	21	ALTA FLORESTA D OESTE	2010-03-11 00:00:00	\N	\N
3851	21	ALTO ALEGRE DOS PARECIS	2010-03-11 00:00:00	\N	\N
3852	21	ALTO PARAÍSO	2010-03-11 00:00:00	\N	\N
3853	21	ALVORADA D OESTE	2010-03-11 00:00:00	\N	\N
3854	21	ARIQUEMES	2010-03-11 00:00:00	\N	\N
3855	21	BURITIS	2010-03-11 00:00:00	\N	\N
3856	21	CABIXI	2010-03-11 00:00:00	\N	\N
3857	21	CACAULÂNDIA	2010-03-11 00:00:00	\N	\N
3858	21	CACOAL	2010-03-11 00:00:00	\N	\N
3859	21	CAMPO NOVO DE RONDÔNIA	2010-03-11 00:00:00	\N	\N
3860	21	CANDEIAS DO JAMARI	2010-03-11 00:00:00	\N	\N
3861	21	CASTANHEIRAS	2010-03-11 00:00:00	\N	\N
3862	21	CEREJEIRAS	2010-03-11 00:00:00	\N	\N
3863	21	CHUPINGUAIA	2010-03-11 00:00:00	\N	\N
3864	21	COLORADO DO OESTE	2010-03-11 00:00:00	\N	\N
3865	21	CORUMBIARA	2010-03-11 00:00:00	\N	\N
3866	21	COSTA MARQUES	2010-03-11 00:00:00	\N	\N
3867	21	CUJUBIM	2010-03-11 00:00:00	\N	\N
3868	21	ESPIGÃO D OESTE	2010-03-11 00:00:00	\N	\N
3869	21	GOVERNADOR JORGE TEIXEIRA	2010-03-11 00:00:00	\N	\N
3870	21	GUAJARÁ-MIRIM	2010-03-11 00:00:00	\N	\N
3871	21	ITAPUÃ DO OESTE	2010-03-11 00:00:00	\N	\N
3872	21	JARU	2010-03-11 00:00:00	\N	\N
3873	21	JI-PARANÁ	2010-03-11 00:00:00	\N	\N
3874	21	MACHADINHO D OESTE	2010-03-11 00:00:00	\N	\N
3875	21	MINISTRO ANDREAZZA	2010-03-11 00:00:00	\N	\N
3876	21	MIRANTE DA SERRA	2010-03-11 00:00:00	\N	\N
3877	21	MONTE NEGRO	2010-03-11 00:00:00	\N	\N
3878	21	NOVA BRASILÂNDIA D OESTE	2010-03-11 00:00:00	\N	\N
3879	21	NOVA MAMORÉ	2010-03-11 00:00:00	\N	\N
3880	21	NOVA UNIÃO	2010-03-11 00:00:00	\N	\N
3881	21	NOVO HORIZONTE D OESTE	2010-03-11 00:00:00	\N	\N
3882	21	OURO PRETO DO OESTE	2010-03-11 00:00:00	\N	\N
3883	21	PARECIS	2010-03-11 00:00:00	\N	\N
3884	21	PIMENTA BUENO	2010-03-11 00:00:00	\N	\N
3885	21	PIMENTEIRAS DO OESTE	2010-03-11 00:00:00	\N	\N
3886	21	PORTO VELHO	2010-03-11 00:00:00	\N	\N
3887	21	PRESIDENTE MÉDICI	2010-03-11 00:00:00	\N	\N
3888	21	PRIMAVERA DE RONDÔNIA	2010-03-11 00:00:00	\N	\N
3889	21	RIO CRESPO	2010-03-11 00:00:00	\N	\N
3890	21	ROLIM DE MOURA	2010-03-11 00:00:00	\N	\N
3891	21	SANTA LUZIA D OESTE	2010-03-11 00:00:00	\N	\N
3892	21	SÃO FELIPE D OESTE	2010-03-11 00:00:00	\N	\N
3893	21	SÃO FRANCISCO DO GUAPORÉ	2010-03-11 00:00:00	\N	\N
3894	21	SÃO MIGUEL DO GUAPORÉ	2010-03-11 00:00:00	\N	\N
3895	21	SERINGUEIRAS	2010-03-11 00:00:00	\N	\N
3896	21	TEIXEIRÓPOLIS	2010-03-11 00:00:00	\N	\N
3897	21	THEOBROMA	2010-03-11 00:00:00	\N	\N
3898	21	URUPA	2010-03-11 00:00:00	\N	\N
3899	21	VALE DO ANARI	2010-03-11 00:00:00	\N	\N
3900	21	VALE DO PARAÍSO	2010-03-11 00:00:00	\N	\N
3901	21	VILHENA	2010-03-11 00:00:00	\N	\N
3902	22	ALTO ALEGRE	2010-03-11 00:00:00	\N	\N
3903	22	AMAJARI	2010-03-11 00:00:00	\N	\N
3904	22	BOA VISTA	2010-03-11 00:00:00	\N	\N
3905	22	BONFIM	2010-03-11 00:00:00	\N	\N
3906	22	CANTA	2010-03-11 00:00:00	\N	\N
3907	22	CARACARAÍ	2010-03-11 00:00:00	\N	\N
3908	22	CAROEBE	2010-03-11 00:00:00	\N	\N
3909	22	IRACEMA	2010-03-11 00:00:00	\N	\N
3910	22	MUCAJAI	2010-03-11 00:00:00	\N	\N
3911	22	NORMÂNDIA	2010-03-11 00:00:00	\N	\N
3912	22	PACARAIMA	2010-03-11 00:00:00	\N	\N
3913	22	RORAINÓPOLIS	2010-03-11 00:00:00	\N	\N
3914	22	SÃO JOÃO DA BALIZA	2010-03-11 00:00:00	\N	\N
3915	22	SÃO LUIZ	2010-03-11 00:00:00	\N	\N
3916	22	UIRAMUTÃ	2010-03-11 00:00:00	\N	\N
3917	23	ACEGUÁ	2010-03-11 00:00:00	\N	\N
3918	23	ÁGUA SANTA	2010-03-11 00:00:00	\N	\N
3919	23	AGUDO	2010-03-11 00:00:00	\N	\N
3920	23	AJURICABA	2010-03-11 00:00:00	\N	\N
3921	23	ALECRIM	2010-03-11 00:00:00	\N	\N
3922	23	ALEGRETE	2010-03-11 00:00:00	\N	\N
3923	23	ALEGRIA	2010-03-11 00:00:00	\N	\N
3924	23	ALMIRANTE TAMANDARÉ DO SUL	2010-03-11 00:00:00	\N	\N
3925	23	ALPESTRE	2010-03-11 00:00:00	\N	\N
3926	23	ALTO ALEGRE	2010-03-11 00:00:00	\N	\N
3927	23	ALTO FELIZ	2010-03-11 00:00:00	\N	\N
3928	23	ALVORADA	2010-03-11 00:00:00	\N	\N
3929	23	AMARAL FERRADOR	2010-03-11 00:00:00	\N	\N
3930	23	AMETISTA DO SUL	2010-03-11 00:00:00	\N	\N
3931	23	ANDRÉ DA ROCHA	2010-03-11 00:00:00	\N	\N
3932	23	ANTA GORDA	2010-03-11 00:00:00	\N	\N
3933	23	ANTÔNIO PRADO	2010-03-11 00:00:00	\N	\N
3934	23	ARAMBARÉ	2010-03-11 00:00:00	\N	\N
3935	23	ARARICÁ	2010-03-11 00:00:00	\N	\N
3936	23	ARATIBA	2010-03-11 00:00:00	\N	\N
3937	23	ARROIO DO MEIO	2010-03-11 00:00:00	\N	\N
3938	23	ARROIO DO PADRE	2010-03-11 00:00:00	\N	\N
3939	23	ARROIO DO SAL	2010-03-11 00:00:00	\N	\N
3940	23	ARROIO DO TIGRE	2010-03-11 00:00:00	\N	\N
3941	23	ARROIO DOS RATOS	2010-03-11 00:00:00	\N	\N
3942	23	ARROIO GRANDE	2010-03-11 00:00:00	\N	\N
3943	23	ARVOREZINHA	2010-03-11 00:00:00	\N	\N
3944	23	AUGUSTO PESTANA	2010-03-11 00:00:00	\N	\N
3945	23	ÁUREA	2010-03-11 00:00:00	\N	\N
3946	23	BAGÉ	2010-03-11 00:00:00	\N	\N
3947	23	BALNEÁRIO PINHAL	2010-03-11 00:00:00	\N	\N
3948	23	BARÃO	2010-03-11 00:00:00	\N	\N
3949	23	BARÃO DE COTEGIPE	2010-03-11 00:00:00	\N	\N
3950	23	BARÃO DO TRIUNFO	2010-03-11 00:00:00	\N	\N
3951	23	BARRA DO GUARITA	2010-03-11 00:00:00	\N	\N
3952	23	BARRA DO QUARAÍ	2010-03-11 00:00:00	\N	\N
3953	23	BARRA DO RIBEIRO	2010-03-11 00:00:00	\N	\N
3954	23	BARRA DO RIO AZUL	2010-03-11 00:00:00	\N	\N
3955	23	BARRA FUNDA	2010-03-11 00:00:00	\N	\N
3956	23	BARRACÃO	2010-03-11 00:00:00	\N	\N
3957	23	BARROS CASSAL	2010-03-11 00:00:00	\N	\N
3958	23	BENJAMIN CONSTANT DO SUL	2010-03-11 00:00:00	\N	\N
3959	23	BENTO GONÇALVES	2010-03-11 00:00:00	\N	\N
3960	23	BOA VISTA DAS MISSÕES	2010-03-11 00:00:00	\N	\N
3961	23	BOA VISTA DO BURICÁ	2010-03-11 00:00:00	\N	\N
3962	23	BOA VISTA DO CADEADO	2010-03-11 00:00:00	\N	\N
3963	23	BOA VISTA DO INCRA	2010-03-11 00:00:00	\N	\N
3964	23	BOA VISTA DO SUL	2010-03-11 00:00:00	\N	\N
3965	23	BOM JESUS	2010-03-11 00:00:00	\N	\N
3966	23	BOM PRINCÍPIO	2010-03-11 00:00:00	\N	\N
3967	23	BOM PROGRESSO	2010-03-11 00:00:00	\N	\N
3968	23	BOM RETIRO DO SUL	2010-03-11 00:00:00	\N	\N
3969	23	BOQUEIRÃO DO LEÃO	2010-03-11 00:00:00	\N	\N
3970	23	BOSSOROCA	2010-03-11 00:00:00	\N	\N
3971	23	BOZANO	2010-03-11 00:00:00	\N	\N
3972	23	BRAGA	2010-03-11 00:00:00	\N	\N
3973	23	BROCHIER	2010-03-11 00:00:00	\N	\N
3974	23	BUTIÁ	2010-03-11 00:00:00	\N	\N
3975	23	CAÇAPAVA DO SUL	2010-03-11 00:00:00	\N	\N
3976	23	CACEQUI	2010-03-11 00:00:00	\N	\N
3977	23	CACHOEIRA DO SUL	2010-03-11 00:00:00	\N	\N
3978	23	CACHOEIRINHA	2010-03-11 00:00:00	\N	\N
3979	23	CACIQUE DOBLE	2010-03-11 00:00:00	\N	\N
3980	23	CAIBATÉ	2010-03-11 00:00:00	\N	\N
3981	23	CAIÇARA	2010-03-11 00:00:00	\N	\N
3982	23	CAMAQUÃ	2010-03-11 00:00:00	\N	\N
3983	23	CAMARGO	2010-03-11 00:00:00	\N	\N
3984	23	CAMBARÁ DO SUL	2010-03-11 00:00:00	\N	\N
3985	23	CAMPESTRE DA SERRA	2010-03-11 00:00:00	\N	\N
3986	23	CAMPINA DAS MISSÕES	2010-03-11 00:00:00	\N	\N
3987	23	CAMPINAS DO SUL	2010-03-11 00:00:00	\N	\N
3988	23	CAMPO BOM	2010-03-11 00:00:00	\N	\N
3989	23	CAMPO NOVO	2010-03-11 00:00:00	\N	\N
3990	23	CAMPOS BORGES	2010-03-11 00:00:00	\N	\N
3991	23	CANDELÁRIA	2010-03-11 00:00:00	\N	\N
3992	23	CÂNDIDO GODÓI	2010-03-11 00:00:00	\N	\N
3993	23	CANDIOTA	2010-03-11 00:00:00	\N	\N
3994	23	CANELA	2010-03-11 00:00:00	\N	\N
3995	23	CANGUÇU	2010-03-11 00:00:00	\N	\N
3996	23	CANOAS	2010-03-11 00:00:00	\N	\N
3997	23	CANUDOS DO VALE	2010-03-11 00:00:00	\N	\N
3998	23	CAPÃO BONITO DO SUL	2010-03-11 00:00:00	\N	\N
3999	23	CAPÃO DA CANOA	2010-03-11 00:00:00	\N	\N
4000	23	CAPÃO DO CIPÓ	2010-03-11 00:00:00	\N	\N
4001	23	CAPÃO DO LEÃO	2010-03-11 00:00:00	\N	\N
4002	23	CAPELA DE SANTANA	2010-03-11 00:00:00	\N	\N
4003	23	CAPITÃO	2010-03-11 00:00:00	\N	\N
4004	23	CAPIVARI DO SUL	2010-03-11 00:00:00	\N	\N
4005	23	CARAÁ	2010-03-11 00:00:00	\N	\N
4006	23	CARAZINHO	2010-03-11 00:00:00	\N	\N
4007	23	CARLOS BARBOSA	2010-03-11 00:00:00	\N	\N
4008	23	CARLOS GOMES	2010-03-11 00:00:00	\N	\N
4009	23	CASCA	2010-03-11 00:00:00	\N	\N
4010	23	CASEIROS	2010-03-11 00:00:00	\N	\N
4011	23	CATUÍPE	2010-03-11 00:00:00	\N	\N
4012	23	CAXIAS DO SUL	2010-03-11 00:00:00	\N	\N
4013	23	CENTENÁRIO	2010-03-11 00:00:00	\N	\N
4014	23	CERRITO	2010-03-11 00:00:00	\N	\N
4015	23	CERRO BRANCO	2010-03-11 00:00:00	\N	\N
4016	23	CERRO GRANDE	2010-03-11 00:00:00	\N	\N
4017	23	CERRO GRANDE DO SUL	2010-03-11 00:00:00	\N	\N
4018	23	CERRO LARGO	2010-03-11 00:00:00	\N	\N
4019	23	CHAPADA	2010-03-11 00:00:00	\N	\N
4020	23	CHARQUEADAS	2010-03-11 00:00:00	\N	\N
4021	23	CHARRUA	2010-03-11 00:00:00	\N	\N
4022	23	CHIAPETTA	2010-03-11 00:00:00	\N	\N
4023	23	CHUÍ	2010-03-11 00:00:00	\N	\N
4024	23	CHUVISCA	2010-03-11 00:00:00	\N	\N
4025	23	CIDREIRA	2010-03-11 00:00:00	\N	\N
4026	23	CIRÍACO	2010-03-11 00:00:00	\N	\N
4027	23	COLINAS	2010-03-11 00:00:00	\N	\N
4028	23	COLORADO	2010-03-11 00:00:00	\N	\N
4029	23	CONDOR	2010-03-11 00:00:00	\N	\N
4030	23	CONSTANTINA	2010-03-11 00:00:00	\N	\N
4031	23	COQUEIRO BAIXO	2010-03-11 00:00:00	\N	\N
4032	23	COQUEIROS DO SUL	2010-03-11 00:00:00	\N	\N
4033	23	CORONEL BARROS	2010-03-11 00:00:00	\N	\N
4034	23	CORONEL BICACO	2010-03-11 00:00:00	\N	\N
4035	23	CORONEL PILAR	2010-03-11 00:00:00	\N	\N
4036	23	COTIPORÃ	2010-03-11 00:00:00	\N	\N
4037	23	COXILHA	2010-03-11 00:00:00	\N	\N
4038	23	CRISSIUMAL	2010-03-11 00:00:00	\N	\N
4039	23	CRISTAL	2010-03-11 00:00:00	\N	\N
4040	23	CRISTAL DO SUL	2010-03-11 00:00:00	\N	\N
4041	23	CRUZ ALTA	2010-03-11 00:00:00	\N	\N
4042	23	CRUZALTENSE	2010-03-11 00:00:00	\N	\N
4043	23	CRUZEIRO DO SUL	2010-03-11 00:00:00	\N	\N
4044	23	DAVID CANABARRO	2010-03-11 00:00:00	\N	\N
4045	23	DERRUBADAS	2010-03-11 00:00:00	\N	\N
4046	23	DEZESSEIS DE NOVEMBRO	2010-03-11 00:00:00	\N	\N
4047	23	DILERMANDO DE AGUIAR	2010-03-11 00:00:00	\N	\N
4048	23	DOIS IRMÃOS	2010-03-11 00:00:00	\N	\N
4049	23	DOIS IRMÃOS DAS MISSÕES	2010-03-11 00:00:00	\N	\N
4050	23	DOIS LAJEADOS	2010-03-11 00:00:00	\N	\N
4051	23	DOM FELICIANO	2010-03-11 00:00:00	\N	\N
4052	23	DOM PEDRITO	2010-03-11 00:00:00	\N	\N
4053	23	DOM PEDRO DE ALCÂNTARA	2010-03-11 00:00:00	\N	\N
4054	23	DONA FRANCISCA	2010-03-11 00:00:00	\N	\N
4055	23	DOUTOR MAURÍCIO CARDOSO	2010-03-11 00:00:00	\N	\N
4056	23	DOUTOR RICARDO	2010-03-11 00:00:00	\N	\N
4057	23	ELDORADO DO SUL	2010-03-11 00:00:00	\N	\N
4058	23	ENCANTADO	2010-03-11 00:00:00	\N	\N
4059	23	ENCRUZILHADA DO SUL	2010-03-11 00:00:00	\N	\N
4060	23	ENGENHO VELHO	2010-03-11 00:00:00	\N	\N
4061	23	ENTRE IJUÍS	2010-03-11 00:00:00	\N	\N
4062	23	ENTRE RIOS DO SUL	2010-03-11 00:00:00	\N	\N
4063	23	EREBANGO	2010-03-11 00:00:00	\N	\N
4064	23	ERECHIM	2010-03-11 00:00:00	\N	\N
4065	23	ERNESTINA	2010-03-11 00:00:00	\N	\N
4066	23	ERVAL GRANDE	2010-03-11 00:00:00	\N	\N
4067	23	ERVAL SECO	2010-03-11 00:00:00	\N	\N
4068	23	ESMERALDA	2010-03-11 00:00:00	\N	\N
4069	23	ESPERANÇA DO SUL	2010-03-11 00:00:00	\N	\N
4070	23	ESPUMOSO	2010-03-11 00:00:00	\N	\N
4071	23	ESTAÇÃO	2010-03-11 00:00:00	\N	\N
4072	23	ESTÂNCIA VELHA	2010-03-11 00:00:00	\N	\N
4073	23	ESTEIO	2010-03-11 00:00:00	\N	\N
4074	23	ESTRELA	2010-03-11 00:00:00	\N	\N
4075	23	ESTRELA VELHA	2010-03-11 00:00:00	\N	\N
4076	23	EUGÊNIO DE CASTRO	2010-03-11 00:00:00	\N	\N
4077	23	FAGUNDES VARELA	2010-03-11 00:00:00	\N	\N
4078	23	FARROUPILHA	2010-03-11 00:00:00	\N	\N
4079	23	FAXINAL DO SOTURNO	2010-03-11 00:00:00	\N	\N
4080	23	FAXINALZINHO	2010-03-11 00:00:00	\N	\N
4081	23	FAZENDA VILANOVA	2010-03-11 00:00:00	\N	\N
4082	23	FELIZ	2010-03-11 00:00:00	\N	\N
4083	23	FLORES DA CUNHA	2010-03-11 00:00:00	\N	\N
4084	23	FLORIANO PEIXOTO	2010-03-11 00:00:00	\N	\N
4085	23	FONTOURA XAVIER	2010-03-11 00:00:00	\N	\N
4086	23	FORMIGUEIRO	2010-03-11 00:00:00	\N	\N
4087	23	FORQUETINHA	2010-03-11 00:00:00	\N	\N
4088	23	FORTALEZA DOS VALOS	2010-03-11 00:00:00	\N	\N
4089	23	FREDERICO WESTPHALEN	2010-03-11 00:00:00	\N	\N
4090	23	GARIBALDI	2010-03-11 00:00:00	\N	\N
4091	23	GARRUCHOS	2010-03-11 00:00:00	\N	\N
4092	23	GAURAMA	2010-03-11 00:00:00	\N	\N
4093	23	GENERAL CÂMARA	2010-03-11 00:00:00	\N	\N
4094	23	GENTIL	2010-03-11 00:00:00	\N	\N
4095	23	GETÚLIO VARGAS	2010-03-11 00:00:00	\N	\N
4096	23	GIRUÁ	2010-03-11 00:00:00	\N	\N
4097	23	GLORINHA	2010-03-11 00:00:00	\N	\N
4098	23	GRAMADO	2010-03-11 00:00:00	\N	\N
4099	23	GRAMADO DOS LOUREIROS	2010-03-11 00:00:00	\N	\N
4100	23	GRAMADO XAVIER	2010-03-11 00:00:00	\N	\N
4101	23	GRAVATAÍ	2010-03-11 00:00:00	\N	\N
4102	23	GUABIJU	2010-03-11 00:00:00	\N	\N
4103	23	GUAÍBA	2010-03-11 00:00:00	\N	\N
4104	23	GUAPORÉ	2010-03-11 00:00:00	\N	\N
4105	23	GUARANI DAS MISSÕES	2010-03-11 00:00:00	\N	\N
4106	23	HARMONIA	2010-03-11 00:00:00	\N	\N
4107	23	HERVAL	2010-03-11 00:00:00	\N	\N
4108	23	HERVEIRAS	2010-03-11 00:00:00	\N	\N
4109	23	HORIZONTINA	2010-03-11 00:00:00	\N	\N
4110	23	HULHA NEGRA	2010-03-11 00:00:00	\N	\N
4111	23	HUMAITÁ	2010-03-11 00:00:00	\N	\N
4112	23	IBARAMA	2010-03-11 00:00:00	\N	\N
4113	23	IBIAÇÁ	2010-03-11 00:00:00	\N	\N
4114	23	IBIRAIARAS	2010-03-11 00:00:00	\N	\N
4115	23	IBIRAPUITÃ	2010-03-11 00:00:00	\N	\N
4116	23	IBIRUBÁ	2010-03-11 00:00:00	\N	\N
4117	23	IGREJINHA	2010-03-11 00:00:00	\N	\N
4118	23	IJUÍ	2010-03-11 00:00:00	\N	\N
4119	23	ILÓPOLIS	2010-03-11 00:00:00	\N	\N
4120	23	IMBÉ	2010-03-11 00:00:00	\N	\N
4121	23	IMIGRANTE	2010-03-11 00:00:00	\N	\N
4122	23	INDEPENDÊNCIA	2010-03-11 00:00:00	\N	\N
4123	23	INHACORÁ	2010-03-11 00:00:00	\N	\N
4124	23	IPÊ	2010-03-11 00:00:00	\N	\N
4125	23	IPIRANGA DO SUL	2010-03-11 00:00:00	\N	\N
4126	23	IRAÍ	2010-03-11 00:00:00	\N	\N
4127	23	ITAÁRA	2010-03-11 00:00:00	\N	\N
4128	23	ITACURUBI	2010-03-11 00:00:00	\N	\N
4129	23	ITAPUCA	2010-03-11 00:00:00	\N	\N
4130	23	ITAQUI	2010-03-11 00:00:00	\N	\N
4131	23	ITATI	2010-03-11 00:00:00	\N	\N
4132	23	ITATIBA DO SUL	2010-03-11 00:00:00	\N	\N
4133	23	IVORÁ	2010-03-11 00:00:00	\N	\N
4134	23	IVOTI	2010-03-11 00:00:00	\N	\N
4135	23	JABOTICABA	2010-03-11 00:00:00	\N	\N
4136	23	JACUIZINHO	2010-03-11 00:00:00	\N	\N
4137	23	JACUTINGA	2010-03-11 00:00:00	\N	\N
4138	23	JAGUARÃO	2010-03-11 00:00:00	\N	\N
4139	23	JAGUARI	2010-03-11 00:00:00	\N	\N
4140	23	JAQUIRANA	2010-03-11 00:00:00	\N	\N
4141	23	JARI	2010-03-11 00:00:00	\N	\N
4142	23	JÓIA	2010-03-11 00:00:00	\N	\N
4143	23	JÚLIO DE CASTILHOS	2010-03-11 00:00:00	\N	\N
4144	23	LAGOA BONITA DO SUL	2010-03-11 00:00:00	\N	\N
4145	23	LAGOA DOS TRÊS CANTOS	2010-03-11 00:00:00	\N	\N
4146	23	LAGOA VERMELHA	2010-03-11 00:00:00	\N	\N
4147	23	LAGOÃO	2010-03-11 00:00:00	\N	\N
4148	23	LAJEADO	2010-03-11 00:00:00	\N	\N
4149	23	LAJEADO DO BUGRE	2010-03-11 00:00:00	\N	\N
4150	23	LAVRAS DO SUL	2010-03-11 00:00:00	\N	\N
4151	23	LIBERATO SALZANO	2010-03-11 00:00:00	\N	\N
4152	23	LINDOLFO COLLOR	2010-03-11 00:00:00	\N	\N
4153	23	LINHA NOVA	2010-03-11 00:00:00	\N	\N
4154	23	MAÇAMBARÁ	2010-03-11 00:00:00	\N	\N
4155	23	MACHADINHO	2010-03-11 00:00:00	\N	\N
4156	23	MAMPITUBA	2010-03-11 00:00:00	\N	\N
4157	23	MANOEL VIANA	2010-03-11 00:00:00	\N	\N
4158	23	MAQUINÉ	2010-03-11 00:00:00	\N	\N
4159	23	MARATÁ	2010-03-11 00:00:00	\N	\N
4160	23	MARAU	2010-03-11 00:00:00	\N	\N
4161	23	MARCELINO RAMOS	2010-03-11 00:00:00	\N	\N
4162	23	MARIANA PIMENTEL	2010-03-11 00:00:00	\N	\N
4163	23	MARIANO MORO	2010-03-11 00:00:00	\N	\N
4164	23	MARQUES DE SOUZA	2010-03-11 00:00:00	\N	\N
4165	23	MATA	2010-03-11 00:00:00	\N	\N
4166	23	MATO CASTELHANO	2010-03-11 00:00:00	\N	\N
4167	23	MATO LEITÃO	2010-03-11 00:00:00	\N	\N
4168	23	MATO QUEIMADO	2010-03-11 00:00:00	\N	\N
4169	23	MAXIMILIANO DE ALMEIDA	2010-03-11 00:00:00	\N	\N
4170	23	MINAS DO LEÃO	2010-03-11 00:00:00	\N	\N
4171	23	MIRAGUAÍ	2010-03-11 00:00:00	\N	\N
4172	23	MONTAURI	2010-03-11 00:00:00	\N	\N
4173	23	MONTE ALEGRE DOS CAMPOS	2010-03-11 00:00:00	\N	\N
4174	23	MONTE BELO DO SUL	2010-03-11 00:00:00	\N	\N
4175	23	MONTENEGRO	2010-03-11 00:00:00	\N	\N
4176	23	MORMAÇO	2010-03-11 00:00:00	\N	\N
4177	23	MORRINHOS DO SUL	2010-03-11 00:00:00	\N	\N
4178	23	MORRO REDONDO	2010-03-11 00:00:00	\N	\N
4179	23	MORRO REUTER	2010-03-11 00:00:00	\N	\N
4180	23	MOSTARDAS	2010-03-11 00:00:00	\N	\N
4181	23	MUÇUM	2010-03-11 00:00:00	\N	\N
4182	23	MUITOS CAPÕES	2010-03-11 00:00:00	\N	\N
4183	23	MULITERNO	2010-03-11 00:00:00	\N	\N
4184	23	NÃO-ME-TOQUE	2010-03-11 00:00:00	\N	\N
4185	23	NICOLAU VERGUEIRO	2010-03-11 00:00:00	\N	\N
4186	23	NONOAÍ	2010-03-11 00:00:00	\N	\N
4187	23	NOVA ALVORADA	2010-03-11 00:00:00	\N	\N
4188	23	NOVA ARAÇÁ	2010-03-11 00:00:00	\N	\N
4189	23	NOVA BASSANO	2010-03-11 00:00:00	\N	\N
4190	23	NOVA BOA VISTA	2010-03-11 00:00:00	\N	\N
4191	23	NOVA BRÉSCIA	2010-03-11 00:00:00	\N	\N
4192	23	NOVA CANDELÁRIA	2010-03-11 00:00:00	\N	\N
4193	23	NOVA ESPERANÇA DO SUL	2010-03-11 00:00:00	\N	\N
4194	23	NOVA HARTZ	2010-03-11 00:00:00	\N	\N
4195	23	NOVA PÁDUA	2010-03-11 00:00:00	\N	\N
4196	23	NOVA PALMA	2010-03-11 00:00:00	\N	\N
4197	23	NOVA PETRÓPOLIS	2010-03-11 00:00:00	\N	\N
4198	23	NOVA PRATA	2010-03-11 00:00:00	\N	\N
4199	23	NOVA RAMADA	2010-03-11 00:00:00	\N	\N
4200	23	NOVA ROMA DO SUL	2010-03-11 00:00:00	\N	\N
4201	23	NOVA SANTA RITA	2010-03-11 00:00:00	\N	\N
4202	23	NOVO BARREIRO	2010-03-11 00:00:00	\N	\N
4203	23	NOVO CABRAIS	2010-03-11 00:00:00	\N	\N
4204	23	NOVO HAMBURGO	2010-03-11 00:00:00	\N	\N
4205	23	NOVO MACHADO	2010-03-11 00:00:00	\N	\N
4206	23	NOVO TIRADENTES	2010-03-11 00:00:00	\N	\N
4207	23	NOVO XINGU	2010-03-11 00:00:00	\N	\N
4208	23	OSÓRIO	2010-03-11 00:00:00	\N	\N
4209	23	PAIM FILHO	2010-03-11 00:00:00	\N	\N
4210	23	PALMARES DO SUL	2010-03-11 00:00:00	\N	\N
4211	23	PALMEIRA DAS MISSÕES	2010-03-11 00:00:00	\N	\N
4212	23	PALMITINHO	2010-03-11 00:00:00	\N	\N
4213	23	PANAMBI	2010-03-11 00:00:00	\N	\N
4214	23	PÂNTANO GRANDE	2010-03-11 00:00:00	\N	\N
4215	23	PARAÍ	2010-03-11 00:00:00	\N	\N
4216	23	PARAÍSO DO SUL	2010-03-11 00:00:00	\N	\N
4217	23	PARECI NOVO	2010-03-11 00:00:00	\N	\N
4218	23	PAROBÉ	2010-03-11 00:00:00	\N	\N
4219	23	PASSA SETE	2010-03-11 00:00:00	\N	\N
4220	23	PASSO DO SOBRADO	2010-03-11 00:00:00	\N	\N
4221	23	PASSO FUNDO	2010-03-11 00:00:00	\N	\N
4222	23	PAULO BENTO	2010-03-11 00:00:00	\N	\N
4223	23	PAVERAMA	2010-03-11 00:00:00	\N	\N
4224	23	PEDRAS ALTAS	2010-03-11 00:00:00	\N	\N
4225	23	PEDRO OSÓRIO	2010-03-11 00:00:00	\N	\N
4226	23	PEJUÇARA	2010-03-11 00:00:00	\N	\N
4228	23	PICADA CAFÉ	2010-03-11 00:00:00	\N	\N
4229	23	PINHAL	2010-03-11 00:00:00	\N	\N
4230	23	PINHAL DA SERRA	2010-03-11 00:00:00	\N	\N
4231	23	PINHAL GRANDE	2010-03-11 00:00:00	\N	\N
4232	23	PINHEIRINHO DO VALE	2010-03-11 00:00:00	\N	\N
4233	23	PINHEIRO MACHADO	2010-03-11 00:00:00	\N	\N
4234	23	PIRAPÓ	2010-03-11 00:00:00	\N	\N
4235	23	PIRATINI	2010-03-11 00:00:00	\N	\N
4236	23	PLANALTO	2010-03-11 00:00:00	\N	\N
4237	23	POÇO DAS ANTAS	2010-03-11 00:00:00	\N	\N
4238	23	PONTÃO	2010-03-11 00:00:00	\N	\N
4239	23	PONTE PRETA	2010-03-11 00:00:00	\N	\N
4240	23	PORTÃO	2010-03-11 00:00:00	\N	\N
4241	23	PORTO ALEGRE	2010-03-11 00:00:00	\N	\N
4242	23	PORTO LUCENA	2010-03-11 00:00:00	\N	\N
4243	23	PORTO MAUÁ	2010-03-11 00:00:00	\N	\N
4244	23	PORTO VERA CRUZ	2010-03-11 00:00:00	\N	\N
4245	23	PORTO XAVIER	2010-03-11 00:00:00	\N	\N
4246	23	POUSO NOVO	2010-03-11 00:00:00	\N	\N
4247	23	PRESIDENTE LUCENA	2010-03-11 00:00:00	\N	\N
4248	23	PROGRESSO	2010-03-11 00:00:00	\N	\N
4249	23	PROTÁSIO ALVES	2010-03-11 00:00:00	\N	\N
4250	23	PUTINGA	2010-03-11 00:00:00	\N	\N
4251	23	QUARAÍ	2010-03-11 00:00:00	\N	\N
4252	23	QUATRO IRMÃOS	2010-03-11 00:00:00	\N	\N
4253	23	QUEVEDOS	2010-03-11 00:00:00	\N	\N
4254	23	QUINZE DE NOVEMBRO	2010-03-11 00:00:00	\N	\N
4255	23	REDENTORA	2010-03-11 00:00:00	\N	\N
4256	23	RELVADO	2010-03-11 00:00:00	\N	\N
4257	23	RESTINGA SECA	2010-03-11 00:00:00	\N	\N
4258	23	RIO DOS ÍNDIOS	2010-03-11 00:00:00	\N	\N
4259	23	RIO GRANDE	2010-03-11 00:00:00	\N	\N
4260	23	RIO PARDO	2010-03-11 00:00:00	\N	\N
4261	23	RIOZINHO	2010-03-11 00:00:00	\N	\N
4262	23	ROCA SALES	2010-03-11 00:00:00	\N	\N
4263	23	RODEIO BONITO	2010-03-11 00:00:00	\N	\N
4264	23	ROLADOR	2010-03-11 00:00:00	\N	\N
4265	23	ROLANTE	2010-03-11 00:00:00	\N	\N
4266	23	RONDA ALTA	2010-03-11 00:00:00	\N	\N
4267	23	RONDINHA	2010-03-11 00:00:00	\N	\N
4268	23	ROQUE GONZALES	2010-03-11 00:00:00	\N	\N
4269	23	ROSÁRIO DO SUL	2010-03-11 00:00:00	\N	\N
4270	23	SAGRADA FAMÍLIA	2010-03-11 00:00:00	\N	\N
4271	23	SALDANHA MARINHO	2010-03-11 00:00:00	\N	\N
4272	23	SALTO DO JACUÍ	2010-03-11 00:00:00	\N	\N
4273	23	SALVADOR DAS MISSÕES	2010-03-11 00:00:00	\N	\N
4274	23	SALVADOR DO SUL	2010-03-11 00:00:00	\N	\N
4275	23	SANANDUVA	2010-03-11 00:00:00	\N	\N
4276	23	SANTA BÁRBARA DO SUL	2010-03-11 00:00:00	\N	\N
4277	23	SANTA CECÍLIA DO SUL	2010-03-11 00:00:00	\N	\N
4278	23	SANTA CLARA DO SUL	2010-03-11 00:00:00	\N	\N
4279	23	SANTA CRUZ DO SUL	2010-03-11 00:00:00	\N	\N
4280	23	SANTA MARGARIDA DO SUL	2010-03-11 00:00:00	\N	\N
4281	23	SANTA MARIA	2010-03-11 00:00:00	\N	\N
4282	23	SANTA MARIA DO HERVAL	2010-03-11 00:00:00	\N	\N
4283	23	SANTA ROSA	2010-03-11 00:00:00	\N	\N
4284	23	SANTA TEREZA	2010-03-11 00:00:00	\N	\N
4285	23	SANTA VITÓRIA DO PALMAR	2010-03-11 00:00:00	\N	\N
4286	23	SANTANA DA BOA VISTA	2010-03-11 00:00:00	\N	\N
4287	23	SANTANA DO LIVRAMENTO	2010-03-11 00:00:00	\N	\N
4288	23	SANTIAGO	2010-03-11 00:00:00	\N	\N
4289	23	SANTO ÂNGELO	2010-03-11 00:00:00	\N	\N
4290	23	SANTO ANTÔNIO DA PATRULHA	2010-03-11 00:00:00	\N	\N
4291	23	SANTO ANTÔNIO DAS MISSÕES	2010-03-11 00:00:00	\N	\N
4292	23	SANTO ANTÔNIO DO PALMA	2010-03-11 00:00:00	\N	\N
4293	23	SANTO ANTÔNIO DO PLANALTO	2010-03-11 00:00:00	\N	\N
4294	23	SANTO AUGUSTO	2010-03-11 00:00:00	\N	\N
4295	23	SANTO CRISTO	2010-03-11 00:00:00	\N	\N
4296	23	SANTO EXPEDITO DO SUL	2010-03-11 00:00:00	\N	\N
4297	23	SÃO BORJA	2010-03-11 00:00:00	\N	\N
4298	23	SÃO DOMINGOS DO SUL	2010-03-11 00:00:00	\N	\N
4299	23	SÃO FRANCISCO DE ASSIS	2010-03-11 00:00:00	\N	\N
4300	23	SÃO FRANCISCO DE PAULA	2010-03-11 00:00:00	\N	\N
4301	23	SÃO GABRIEL	2010-03-11 00:00:00	\N	\N
4302	23	SÃO JERÔNIMO	2010-03-11 00:00:00	\N	\N
4303	23	SÃO JOÃO DA URTIGA	2010-03-11 00:00:00	\N	\N
4304	23	SÃO JOÃO DO POLÊSINE	2010-03-11 00:00:00	\N	\N
4305	23	SÃO JORGE	2010-03-11 00:00:00	\N	\N
4306	23	SÃO JOSÉ DAS MISSÕES	2010-03-11 00:00:00	\N	\N
4307	23	SÃO JOSÉ DO HERVAL	2010-03-11 00:00:00	\N	\N
4308	23	SÃO JOSÉ DO HORTÊNCIO	2010-03-11 00:00:00	\N	\N
4309	23	SÃO JOSÉ DO INHACORÁ	2010-03-11 00:00:00	\N	\N
4310	23	SÃO JOSÉ DO NORTE	2010-03-11 00:00:00	\N	\N
4311	23	SÃO JOSÉ DO OURO	2010-03-11 00:00:00	\N	\N
4312	23	SÃO JOSÉ DO SUL	2010-03-11 00:00:00	\N	\N
4313	23	SÃO JOSÉ DOS AUSENTES	2010-03-11 00:00:00	\N	\N
4314	23	SÃO LEOPOLDO	2010-03-11 00:00:00	\N	\N
4315	23	SÃO LOURENÇO DO SUL	2010-03-11 00:00:00	\N	\N
4316	23	SÃO LUIZ GONZAGA	2010-03-11 00:00:00	\N	\N
4317	23	SÃO MARCOS	2010-03-11 00:00:00	\N	\N
4318	23	SÃO MARTINHO	2010-03-11 00:00:00	\N	\N
4319	23	SÃO MARTINHO DA SERRA	2010-03-11 00:00:00	\N	\N
4320	23	SÃO MIGUEL DAS MISSÕES	2010-03-11 00:00:00	\N	\N
4321	23	SÃO NICOLAU	2010-03-11 00:00:00	\N	\N
4322	23	SÃO PAULO DAS MISSÕES	2010-03-11 00:00:00	\N	\N
4323	23	SÃO PEDRO DA SERRA	2010-03-11 00:00:00	\N	\N
4324	23	SÃO PEDRO DAS MISSÕES	2010-03-11 00:00:00	\N	\N
4325	23	SÃO PEDRO DO BUTIÁ	2010-03-11 00:00:00	\N	\N
4326	23	SÃO PEDRO DO SUL	2010-03-11 00:00:00	\N	\N
4327	23	SÃO SEBASTIÃO DO CAÍ	2010-03-11 00:00:00	\N	\N
4328	23	SÃO SEPÉ	2010-03-11 00:00:00	\N	\N
4329	23	SÃO VALENTIM	2010-03-11 00:00:00	\N	\N
4330	23	SÃO VALENTIM DO SUL	2010-03-11 00:00:00	\N	\N
4331	23	SÃO VALÉRIO DO SUL	2010-03-11 00:00:00	\N	\N
4332	23	SÃO VENDELINO	2010-03-11 00:00:00	\N	\N
4333	23	SÃO VICENTE DO SUL	2010-03-11 00:00:00	\N	\N
4334	23	SAPIRANGA	2010-03-11 00:00:00	\N	\N
4335	23	SAPUCAIA DO SUL	2010-03-11 00:00:00	\N	\N
4336	23	SARANDI	2010-03-11 00:00:00	\N	\N
4337	23	SEBERI	2010-03-11 00:00:00	\N	\N
4338	23	SEDE NOVA	2010-03-11 00:00:00	\N	\N
4339	23	SEGREDO	2010-03-11 00:00:00	\N	\N
4340	23	SELBACH	2010-03-11 00:00:00	\N	\N
4341	23	SENADOR SALGADO FILHO	2010-03-11 00:00:00	\N	\N
4342	23	SENTINELA DO SUL	2010-03-11 00:00:00	\N	\N
4343	23	SERAFINA CÔRREA	2010-03-11 00:00:00	\N	\N
4344	23	SÉRIO	2010-03-11 00:00:00	\N	\N
4345	23	SERTÃO 	2010-03-11 00:00:00	\N	\N
4346	23	SERTÃO SANTANA	2010-03-11 00:00:00	\N	\N
4347	23	SETE DE SETEMBRO	2010-03-11 00:00:00	\N	\N
4348	23	SEVERIANO DE ALMEIDA	2010-03-11 00:00:00	\N	\N
4349	23	SILVEIRA MARTINS	2010-03-11 00:00:00	\N	\N
4350	23	SINIMBU	2010-03-11 00:00:00	\N	\N
4351	23	SOBRADINHO	2010-03-11 00:00:00	\N	\N
4352	23	SOLEDADE	2010-03-11 00:00:00	\N	\N
4353	23	TABAÍ	2010-03-11 00:00:00	\N	\N
4354	23	TAPEJARA	2010-03-11 00:00:00	\N	\N
4355	23	TAPERA	2010-03-11 00:00:00	\N	\N
4356	23	TAPES	2010-03-11 00:00:00	\N	\N
4357	23	TAQUARA	2010-03-11 00:00:00	\N	\N
4358	23	TAQUARAÇU DO SUL	2010-03-11 00:00:00	\N	\N
4359	23	TAQUARI	2010-03-11 00:00:00	\N	\N
4360	23	TAVARES	2010-03-11 00:00:00	\N	\N
4361	23	TENENTE PORTELA	2010-03-11 00:00:00	\N	\N
4362	23	TERRA DE AREIA	2010-03-11 00:00:00	\N	\N
4363	23	TEUTÔNIA	2010-03-11 00:00:00	\N	\N
4364	23	TIO HUGO	2010-03-11 00:00:00	\N	\N
4365	23	TIRADENTES DO SUL	2010-03-11 00:00:00	\N	\N
4366	23	TOROPI	2010-03-11 00:00:00	\N	\N
4367	23	TORRES	2010-03-11 00:00:00	\N	\N
4368	23	TRAMANDAÍ	2010-03-11 00:00:00	\N	\N
4369	23	TRAVESSEIRO	2010-03-11 00:00:00	\N	\N
4370	23	TRÊS ARROIOS	2010-03-11 00:00:00	\N	\N
4371	23	TRÊS CACHOEIRAS	2010-03-11 00:00:00	\N	\N
4372	23	TRÊS COROAS	2010-03-11 00:00:00	\N	\N
4373	23	TRÊS DE MAIO	2010-03-11 00:00:00	\N	\N
4374	23	TRÊS FORQUILHAS	2010-03-11 00:00:00	\N	\N
4375	23	TRÊS PALMEIRAS	2010-03-11 00:00:00	\N	\N
4376	23	TRÊS PASSOS	2010-03-11 00:00:00	\N	\N
4377	23	TRINDADE DO SUL	2010-03-11 00:00:00	\N	\N
4378	23	TRIUNFO	2010-03-11 00:00:00	\N	\N
4379	23	TUCUNDUVA	2010-03-11 00:00:00	\N	\N
4380	23	TUNAS	2010-03-11 00:00:00	\N	\N
4381	23	TUPANCI DO SUL	2010-03-11 00:00:00	\N	\N
4382	23	TUPANCIRETÃ	2010-03-11 00:00:00	\N	\N
4383	23	TUPANDI	2010-03-11 00:00:00	\N	\N
4384	23	TUPARENDI	2010-03-11 00:00:00	\N	\N
4385	23	TURUÇU	2010-03-11 00:00:00	\N	\N
4386	23	UBIRETAMA	2010-03-11 00:00:00	\N	\N
4387	23	UNIÃO DA SERRA	2010-03-11 00:00:00	\N	\N
4388	23	UNISTALDA	2010-03-11 00:00:00	\N	\N
4389	23	URUGUAIANA	2010-03-11 00:00:00	\N	\N
4390	23	VACARIA	2010-03-11 00:00:00	\N	\N
4391	23	VALE DO SOL	2010-03-11 00:00:00	\N	\N
4392	23	VALE REAL	2010-03-11 00:00:00	\N	\N
4393	23	VALE VERDE	2010-03-11 00:00:00	\N	\N
4394	23	VANINI	2010-03-11 00:00:00	\N	\N
4395	23	VENÂNCIO AIRES	2010-03-11 00:00:00	\N	\N
4396	23	VERA CRUZ	2010-03-11 00:00:00	\N	\N
4397	23	VERANÓPOLIS	2010-03-11 00:00:00	\N	\N
4398	23	VESPASIANO CORREA	2010-03-11 00:00:00	\N	\N
4399	23	VIADUTOS	2010-03-11 00:00:00	\N	\N
4400	23	VIAMÃO	2010-03-11 00:00:00	\N	\N
4401	23	VICENTE DUTRA	2010-03-11 00:00:00	\N	\N
4402	23	VICTOR GRAEFF	2010-03-11 00:00:00	\N	\N
4403	23	VILA FLORES	2010-03-11 00:00:00	\N	\N
4404	23	VILA LÂNGARO	2010-03-11 00:00:00	\N	\N
4405	23	VILA MARIA	2010-03-11 00:00:00	\N	\N
4406	23	VILA NOVA DO SUL	2010-03-11 00:00:00	\N	\N
4407	23	VISTA ALEGRE	2010-03-11 00:00:00	\N	\N
4408	23	VISTA ALEGRE DO PRATA	2010-03-11 00:00:00	\N	\N
4409	23	VISTA GAÚCHA	2010-03-11 00:00:00	\N	\N
4410	23	VITÓRIA DAS MISSÕES	2010-03-11 00:00:00	\N	\N
4411	23	WESTFÁLIA	2010-03-11 00:00:00	\N	\N
4412	23	XANGRI-LÁ	2010-03-11 00:00:00	\N	\N
4413	24	ABDON BATISTA	2010-03-11 00:00:00	\N	\N
4414	24	ABELARDO LUZ	2010-03-11 00:00:00	\N	\N
4415	24	AGROLÂNDIA	2010-03-11 00:00:00	\N	\N
4416	24	AGRONÔMICA	2010-03-11 00:00:00	\N	\N
4417	24	ÁGUA DOCE	2010-03-11 00:00:00	\N	\N
4418	24	ÁGUAS DE CHAPECÓ	2010-03-11 00:00:00	\N	\N
4419	24	ÁGUAS FRIAS	2010-03-11 00:00:00	\N	\N
4420	24	ÁGUAS MORNAS	2010-03-11 00:00:00	\N	\N
4421	24	ALFREDO WAGNER	2010-03-11 00:00:00	\N	\N
4422	24	ALTO BELA VISTA	2010-03-11 00:00:00	\N	\N
4423	24	ANCHIETA	2010-03-11 00:00:00	\N	\N
4424	24	ANGELINA	2010-03-11 00:00:00	\N	\N
4425	24	ANITA GARIBALDI	2010-03-11 00:00:00	\N	\N
4426	24	ANITÁPOLIS	2010-03-11 00:00:00	\N	\N
4427	24	ANTÔNIO CARLOS	2010-03-11 00:00:00	\N	\N
4428	24	APIÚNA	2010-03-11 00:00:00	\N	\N
4429	24	ARABUTÃ	2010-03-11 00:00:00	\N	\N
4430	24	ARAQUARI	2010-03-11 00:00:00	\N	\N
4431	24	ARARANGUÁ	2010-03-11 00:00:00	\N	\N
4432	24	ARMAZÉM	2010-03-11 00:00:00	\N	\N
4433	24	ARROIO TRINTA	2010-03-11 00:00:00	\N	\N
4434	24	ARVOREDO	2010-03-11 00:00:00	\N	\N
4435	24	ASCURRA	2010-03-11 00:00:00	\N	\N
4436	24	ATALANTA	2010-03-11 00:00:00	\N	\N
4437	24	AURORA	2010-03-11 00:00:00	\N	\N
4438	24	BALNEÁRIO ARROIO DO SILVA	2010-03-11 00:00:00	\N	\N
4439	24	BALNEÁRIO BARRA DO SUL	2010-03-11 00:00:00	\N	\N
4440	24	BALNEÁRIO CAMBORIÚ	2010-03-11 00:00:00	\N	\N
4441	24	BALNEÁRIO GAIVOTA	2010-03-11 00:00:00	\N	\N
4442	24	BALNEÁRIO PIÇARRAS	2010-03-11 00:00:00	\N	\N
4443	24	BANDEIRANTE	2010-03-11 00:00:00	\N	\N
4444	24	BARRA BONITA	2010-03-11 00:00:00	\N	\N
4445	24	BARRA VELHA	2010-03-11 00:00:00	\N	\N
4446	24	BELA VISTA DO TOLDO	2010-03-11 00:00:00	\N	\N
4447	24	BELMONTE	2010-03-11 00:00:00	\N	\N
4448	24	BENEDITO NOVO	2010-03-11 00:00:00	\N	\N
4449	24	BIGUAÇU	2010-03-11 00:00:00	\N	\N
4450	24	BLUMENAU	2010-03-11 00:00:00	\N	\N
4451	24	BOCAINA DO SUL	2010-03-11 00:00:00	\N	\N
4452	24	BOM JARDIM DA SERRA	2010-03-11 00:00:00	\N	\N
4453	24	BOM JESUS	2010-03-11 00:00:00	\N	\N
4454	24	BOM JESUS DO OESTE	2010-03-11 00:00:00	\N	\N
4455	24	BOM RETIRO	2010-03-11 00:00:00	\N	\N
4456	24	BOMBINHAS	2010-03-11 00:00:00	\N	\N
4457	24	BOTUVERÁ	2010-03-11 00:00:00	\N	\N
4458	24	BRAÇO DO NORTE	2010-03-11 00:00:00	\N	\N
4459	24	BRAÇO DO TROMBUDO	2010-03-11 00:00:00	\N	\N
4460	24	BRUNÓPOLIS	2010-03-11 00:00:00	\N	\N
4461	24	BRUSQUE	2010-03-11 00:00:00	\N	\N
4462	24	CAÇADOR	2010-03-11 00:00:00	\N	\N
4463	24	CAIBI	2010-03-11 00:00:00	\N	\N
4464	24	CALMON	2010-03-11 00:00:00	\N	\N
4465	24	CAMBORIÚ	2010-03-11 00:00:00	\N	\N
4466	24	CAMPO ALEGRE	2010-03-11 00:00:00	\N	\N
4467	24	CAMPO BELO DO SUL	2010-03-11 00:00:00	\N	\N
4468	24	CAMPO ERÊ	2010-03-11 00:00:00	\N	\N
4469	24	CAMPOS NOVOS	2010-03-11 00:00:00	\N	\N
4470	24	CANELINHA	2010-03-11 00:00:00	\N	\N
4471	24	CANOINHAS	2010-03-11 00:00:00	\N	\N
4472	24	CAPÃO ALTO	2010-03-11 00:00:00	\N	\N
4473	24	CAPINZAL	2010-03-11 00:00:00	\N	\N
4474	24	CAPIVARI DE BAIXO	2010-03-11 00:00:00	\N	\N
4475	24	CATANDUVAS	2010-03-11 00:00:00	\N	\N
4476	24	CAXAMBU DO SUL	2010-03-11 00:00:00	\N	\N
4477	24	CELSO RAMOS	2010-03-11 00:00:00	\N	\N
4478	24	CERRO NEGRO	2010-03-11 00:00:00	\N	\N
4479	24	CHAPADÃO DO LAGEADO	2010-03-11 00:00:00	\N	\N
4480	24	CHAPECÓ	2010-03-11 00:00:00	\N	\N
4481	24	COCAL DO SUL	2010-03-11 00:00:00	\N	\N
4482	24	CONCÓRDIA	2010-03-11 00:00:00	\N	\N
4483	24	CORDILHEIRA ALTA	2010-03-11 00:00:00	\N	\N
4484	24	CORONEL FREITAS	2010-03-11 00:00:00	\N	\N
4485	24	CORONEL MARTINS	2010-03-11 00:00:00	\N	\N
4486	24	CORREIA PINTO	2010-03-11 00:00:00	\N	\N
4487	24	CORUPÁ	2010-03-11 00:00:00	\N	\N
4488	24	CRICIÚMA	2010-03-11 00:00:00	\N	\N
4489	24	CUNHA PORÃ	2010-03-11 00:00:00	\N	\N
4490	24	CUNHATAÍ	2010-03-11 00:00:00	\N	\N
4491	24	CURITIBANOS	2010-03-11 00:00:00	\N	\N
4492	24	DESCANSO	2010-03-11 00:00:00	\N	\N
4493	24	DIONÍSIO CERQUEIRA	2010-03-11 00:00:00	\N	\N
4494	24	DONA EMMA	2010-03-11 00:00:00	\N	\N
4495	24	DOUTOR PEDRINHO	2010-03-11 00:00:00	\N	\N
4496	24	ENTRE RIOS	2010-03-11 00:00:00	\N	\N
4497	24	ERMO	2010-03-11 00:00:00	\N	\N
4498	24	ERVAL VELHO	2010-03-11 00:00:00	\N	\N
4499	24	FAXINAL DOS GUEDES	2010-03-11 00:00:00	\N	\N
4500	24	FLOR DO SERTÃO	2010-03-11 00:00:00	\N	\N
4501	24	FLORIANÓPOLIS	2010-03-11 00:00:00	\N	\N
4502	24	FORMOSA DO SUL	2010-03-11 00:00:00	\N	\N
4503	24	FORQUILHINHA	2010-03-11 00:00:00	\N	\N
4504	24	FRAIBURGO	2010-03-11 00:00:00	\N	\N
4505	24	FREI ROGÉRIO	2010-03-11 00:00:00	\N	\N
4506	24	GALVÃO	2010-03-11 00:00:00	\N	\N
4507	24	GAROPABA	2010-03-11 00:00:00	\N	\N
4508	24	GARUVA	2010-03-11 00:00:00	\N	\N
4509	24	GASPAR	2010-03-11 00:00:00	\N	\N
4510	24	GOVERNADOR CELSO RAMOS	2010-03-11 00:00:00	\N	\N
4511	24	GRÃO PARÁ	2010-03-11 00:00:00	\N	\N
4512	24	GRAVATAL	2010-03-11 00:00:00	\N	\N
4513	24	GUABIRUBA	2010-03-11 00:00:00	\N	\N
4514	24	GUARACIABA	2010-03-11 00:00:00	\N	\N
4515	24	GUARAMIRIM	2010-03-11 00:00:00	\N	\N
4516	24	GUARUJÁ DO SUL	2010-03-11 00:00:00	\N	\N
4517	24	GUATAMBU	2010-03-11 00:00:00	\N	\N
4518	24	HERVAL D OESTE	2010-03-11 00:00:00	\N	\N
4519	24	IBIAM	2010-03-11 00:00:00	\N	\N
4520	24	IBICARÉ	2010-03-11 00:00:00	\N	\N
4521	24	IBIRAMA	2010-03-11 00:00:00	\N	\N
4522	24	IÇARA	2010-03-11 00:00:00	\N	\N
4523	24	ILHOTA	2010-03-11 00:00:00	\N	\N
4524	24	IMARUÍ	2010-03-11 00:00:00	\N	\N
4525	24	IMBITUBA	2010-03-11 00:00:00	\N	\N
4526	24	IMBUIA	2010-03-11 00:00:00	\N	\N
4527	24	INDAIAL	2010-03-11 00:00:00	\N	\N
4528	24	IOMERÊ	2010-03-11 00:00:00	\N	\N
4529	24	IPIRA	2010-03-11 00:00:00	\N	\N
4530	24	IPORÃ DO OESTE	2010-03-11 00:00:00	\N	\N
4531	24	IPUAÇU	2010-03-11 00:00:00	\N	\N
4532	24	IPUMIRIM	2010-03-11 00:00:00	\N	\N
4533	24	IRACEMINHA	2010-03-11 00:00:00	\N	\N
4534	24	IRANI	2010-03-11 00:00:00	\N	\N
4535	24	IRATI	2010-03-11 00:00:00	\N	\N
4536	24	IRINEÓPOLIS	2010-03-11 00:00:00	\N	\N
4537	24	ITÁ	2010-03-11 00:00:00	\N	\N
4538	24	ITAIÓPOLIS	2010-03-11 00:00:00	\N	\N
4539	24	ITAJAÍ	2010-03-11 00:00:00	\N	\N
4540	24	ITAPEMA	2010-03-11 00:00:00	\N	\N
4541	24	ITAPIRANGA	2010-03-11 00:00:00	\N	\N
4542	24	ITAPOÁ	2010-03-11 00:00:00	\N	\N
4543	24	ITUPORANGA	2010-03-11 00:00:00	\N	\N
4544	24	JABORÁ	2010-03-11 00:00:00	\N	\N
4545	24	JACINTO MACHADO	2010-03-11 00:00:00	\N	\N
4546	24	JAGUARUNA	2010-03-11 00:00:00	\N	\N
4547	24	JARAGUÁ DO SUL	2010-03-11 00:00:00	\N	\N
4548	24	JARDINÓPOLIS	2010-03-11 00:00:00	\N	\N
4549	24	JOAÇABA	2010-03-11 00:00:00	\N	\N
4550	24	JOINVILLE	2010-03-11 00:00:00	\N	\N
4551	24	JOSÉ BOITEUX	2010-03-11 00:00:00	\N	\N
4552	24	JUPIÁ	2010-03-11 00:00:00	\N	\N
4553	24	LACERDÓPOLIS	2010-03-11 00:00:00	\N	\N
4554	24	LAGES	2010-03-11 00:00:00	\N	\N
4555	24	LAGUNA	2010-03-11 00:00:00	\N	\N
4556	24	LAJEADO GRANDE	2010-03-11 00:00:00	\N	\N
4557	24	LAURENTINO	2010-03-11 00:00:00	\N	\N
4558	24	LAURO MULLER	2010-03-11 00:00:00	\N	\N
4559	24	LEBON RÉGIS	2010-03-11 00:00:00	\N	\N
4560	24	LEOBERTO LEAL	2010-03-11 00:00:00	\N	\N
4561	24	LINDÓIA DO SUL	2010-03-11 00:00:00	\N	\N
4562	24	LONTRAS	2010-03-11 00:00:00	\N	\N
4563	24	LUIZ ALVES	2010-03-11 00:00:00	\N	\N
4564	24	LUZERNA	2010-03-11 00:00:00	\N	\N
4565	24	MACIEIRA	2010-03-11 00:00:00	\N	\N
4566	24	MAFRA	2010-03-11 00:00:00	\N	\N
4567	24	MAJOR GERCINO	2010-03-11 00:00:00	\N	\N
4568	24	MAJOR VIEIRA	2010-03-11 00:00:00	\N	\N
4569	24	MARACAJÁ	2010-03-11 00:00:00	\N	\N
4570	24	MARAVILHA	2010-03-11 00:00:00	\N	\N
4571	24	MAREMA	2010-03-11 00:00:00	\N	\N
4572	24	MASSARANDUBA	2010-03-11 00:00:00	\N	\N
4573	24	MATOS COSTA	2010-03-11 00:00:00	\N	\N
4574	24	MELEIRO	2010-03-11 00:00:00	\N	\N
4575	24	MIRIM DOCE	2010-03-11 00:00:00	\N	\N
4576	24	MODELO	2010-03-11 00:00:00	\N	\N
4577	24	MONDAÍ	2010-03-11 00:00:00	\N	\N
4578	24	MONTE CARLO	2010-03-11 00:00:00	\N	\N
4579	24	MONTE CASTELO	2010-03-11 00:00:00	\N	\N
4580	24	MORRO DA FUMAÇA	2010-03-11 00:00:00	\N	\N
4581	24	MORRO GRANDE	2010-03-11 00:00:00	\N	\N
4582	24	NAVEGANTES	2010-03-11 00:00:00	\N	\N
4583	24	NOVA ERECHIM	2010-03-11 00:00:00	\N	\N
4584	24	NOVA ITABERABA	2010-03-11 00:00:00	\N	\N
4585	24	NOVA TRENTO	2010-03-11 00:00:00	\N	\N
4586	24	NOVA VENEZA	2010-03-11 00:00:00	\N	\N
4587	24	NOVO HORIZONTE	2010-03-11 00:00:00	\N	\N
4588	24	ORLEANS	2010-03-11 00:00:00	\N	\N
4589	24	OTACÍLIO COSTA	2010-03-11 00:00:00	\N	\N
4590	24	OURO	2010-03-11 00:00:00	\N	\N
4591	24	OURO VERDE	2010-03-11 00:00:00	\N	\N
4592	24	PAIAL	2010-03-11 00:00:00	\N	\N
4593	24	PAINEL	2010-03-11 00:00:00	\N	\N
4594	24	PALHOÇA	2010-03-11 00:00:00	\N	\N
4595	24	PALMA SOLA	2010-03-11 00:00:00	\N	\N
4596	24	PALMEIRA	2010-03-11 00:00:00	\N	\N
4597	24	PALMITOS	2010-03-11 00:00:00	\N	\N
4598	24	PAPANDUVA	2010-03-11 00:00:00	\N	\N
4599	24	PARAÍSO	2010-03-11 00:00:00	\N	\N
4600	24	PASSO DE TORRES	2010-03-11 00:00:00	\N	\N
4601	24	PASSOS MAIA	2010-03-11 00:00:00	\N	\N
4602	24	PAULO LOPES	2010-03-11 00:00:00	\N	\N
4603	24	PEDRAS GRANDES	2010-03-11 00:00:00	\N	\N
4604	24	PENHA	2010-03-11 00:00:00	\N	\N
4605	24	PERITIBA	2010-03-11 00:00:00	\N	\N
4606	24	PETROLÂNDIA	2010-03-11 00:00:00	\N	\N
4607	24	PINHALZINHO	2010-03-11 00:00:00	\N	\N
4608	24	PINHEIRO PRETO	2010-03-11 00:00:00	\N	\N
4609	24	PIRATUBA	2010-03-11 00:00:00	\N	\N
4610	24	PLANALTO ALEGRE	2010-03-11 00:00:00	\N	\N
4611	24	POMERODE	2010-03-11 00:00:00	\N	\N
4612	24	PONTE ALTA	2010-03-11 00:00:00	\N	\N
4613	24	PONTE ALTA DO NORTE	2010-03-11 00:00:00	\N	\N
4614	24	PONTE SERRADA	2010-03-11 00:00:00	\N	\N
4615	24	PORTO BELO	2010-03-11 00:00:00	\N	\N
4616	24	PORTO UNIÃO	2010-03-11 00:00:00	\N	\N
4617	24	POUSO REDONDO	2010-03-11 00:00:00	\N	\N
4618	24	PRAIA GRANDE	2010-03-11 00:00:00	\N	\N
4619	24	PRESIDENTE CASTELLO BRANCO	2010-03-11 00:00:00	\N	\N
4620	24	PRESIDENTE GETÚLIO	2010-03-11 00:00:00	\N	\N
4621	24	PRESIDENTE NEREU	2010-03-11 00:00:00	\N	\N
4622	24	PRINCESA	2010-03-11 00:00:00	\N	\N
4623	24	QUILOMBO	2010-03-11 00:00:00	\N	\N
4624	24	RANCHO QUEIMADO	2010-03-11 00:00:00	\N	\N
4625	24	RIO DAS ANTAS	2010-03-11 00:00:00	\N	\N
4626	24	RIO DO CAMPO	2010-03-11 00:00:00	\N	\N
4627	24	RIO DO OESTE	2010-03-11 00:00:00	\N	\N
4628	24	RIO DO SUL	2010-03-11 00:00:00	\N	\N
4629	24	RIO DOS CEDROS	2010-03-11 00:00:00	\N	\N
4630	24	RIO FORTUNA	2010-03-11 00:00:00	\N	\N
4631	24	RIO NEGRINHO	2010-03-11 00:00:00	\N	\N
4632	24	RIO RUFINO	2010-03-11 00:00:00	\N	\N
4633	24	RIQUEZA	2010-03-11 00:00:00	\N	\N
4634	24	RODEIO	2010-03-11 00:00:00	\N	\N
4635	24	ROMELÂNDIA	2010-03-11 00:00:00	\N	\N
4636	24	SALETE	2010-03-11 00:00:00	\N	\N
4637	24	SALTINHO	2010-03-11 00:00:00	\N	\N
4638	24	SALTO VELOSO	2010-03-11 00:00:00	\N	\N
4639	24	SANGÃO	2010-03-11 00:00:00	\N	\N
4640	24	SANTA CECÍLIA	2010-03-11 00:00:00	\N	\N
4641	24	SANTA HELENA	2010-03-11 00:00:00	\N	\N
4642	24	SANTA ROSA DE LIMA	2010-03-11 00:00:00	\N	\N
4643	24	SANTA ROSA DO SUL	2010-03-11 00:00:00	\N	\N
4644	24	SANTA TEREZINHA	2010-03-11 00:00:00	\N	\N
4645	24	SANTA TEREZINHA DO PROGRESSO	2010-03-11 00:00:00	\N	\N
4646	24	SANTIAGO DO SUL	2010-03-11 00:00:00	\N	\N
4647	24	SANTO AMARO DA IMPERATRIZ	2010-03-11 00:00:00	\N	\N
4648	24	SÃO BENTO DO SUL	2010-03-11 00:00:00	\N	\N
4649	24	SÃO BERNARDINO	2010-03-11 00:00:00	\N	\N
4650	24	SÃO BONIFÁCIO	2010-03-11 00:00:00	\N	\N
4651	24	SÃO CARLOS	2010-03-11 00:00:00	\N	\N
4652	24	SÃO CRISTÓVÃO DO SUL	2010-03-11 00:00:00	\N	\N
4653	24	SÃO DOMINGOS	2010-03-11 00:00:00	\N	\N
4654	24	SÃO FRANCISCO DO SUL	2010-03-11 00:00:00	\N	\N
4655	24	SÃO JOÃO BATISTA	2010-03-11 00:00:00	\N	\N
4656	24	SÃO JOÃO DO ITAPERIU	2010-03-11 00:00:00	\N	\N
4657	24	SÃO JOÃO DO OESTE	2010-03-11 00:00:00	\N	\N
4658	24	SÃO JOÃO DO SUL	2010-03-11 00:00:00	\N	\N
4659	24	SÃO JOAQUIM	2010-03-11 00:00:00	\N	\N
4660	24	SÃO JOSÉ	2010-03-11 00:00:00	\N	\N
4661	24	SÃO JOSÉ DO CEDRO	2010-03-11 00:00:00	\N	\N
4662	24	SÃO JOSÉ DO CERRITO	2010-03-11 00:00:00	\N	\N
4663	24	SÃO LOURENÇO DO OESTE	2010-03-11 00:00:00	\N	\N
4664	24	SÃO LUDGERO	2010-03-11 00:00:00	\N	\N
4665	24	SÃO MARTINHO	2010-03-11 00:00:00	\N	\N
4666	24	SÃO MIGUEL D OESTE	2010-03-11 00:00:00	\N	\N
4667	24	SÃO MIGUEL DA BOA VISTA	2010-03-11 00:00:00	\N	\N
4668	24	SÃO PEDRO DE ALCÂNTARA	2010-03-11 00:00:00	\N	\N
4669	24	SAUDADES	2010-03-11 00:00:00	\N	\N
4670	24	SCHROEDER	2010-03-11 00:00:00	\N	\N
4671	24	SEARA	2010-03-11 00:00:00	\N	\N
4672	24	SERRA ALTA	2010-03-11 00:00:00	\N	\N
4673	24	SIDERÓPOLIS	2010-03-11 00:00:00	\N	\N
4674	24	SOMBRIO	2010-03-11 00:00:00	\N	\N
4675	24	SUL BRASIL	2010-03-11 00:00:00	\N	\N
4676	24	TAIÓ	2010-03-11 00:00:00	\N	\N
4677	24	TANGARÁ	2010-03-11 00:00:00	\N	\N
4678	24	TIGRINHOS	2010-03-11 00:00:00	\N	\N
4679	24	TIJUCAS	2010-03-11 00:00:00	\N	\N
4680	24	TIMBÉ DO SUL	2010-03-11 00:00:00	\N	\N
4681	24	TIMBÓ	2010-03-11 00:00:00	\N	\N
4682	24	TIMBÓ GRANDE	2010-03-11 00:00:00	\N	\N
4683	24	TRÊS BARRAS	2010-03-11 00:00:00	\N	\N
4684	24	TREVISO	2010-03-11 00:00:00	\N	\N
4685	24	TREZE DE MAIO	2010-03-11 00:00:00	\N	\N
4686	24	TREZE TÍLIAS	2010-03-11 00:00:00	\N	\N
4687	24	TROMBUDO CENTRAL	2010-03-11 00:00:00	\N	\N
4688	24	TUBARÃO	2010-03-11 00:00:00	\N	\N
4689	24	TUNÁPOLIS	2010-03-11 00:00:00	\N	\N
4690	24	TURVO	2010-03-11 00:00:00	\N	\N
4691	24	UNIÃO DO OESTE	2010-03-11 00:00:00	\N	\N
4692	24	URUBICI	2010-03-11 00:00:00	\N	\N
4693	24	URUPEMA	2010-03-11 00:00:00	\N	\N
4694	24	URUSSANGA	2010-03-11 00:00:00	\N	\N
4695	24	VARGEÃO	2010-03-11 00:00:00	\N	\N
4696	24	VARGEM	2010-03-11 00:00:00	\N	\N
4697	24	VARGEM BONITA	2010-03-11 00:00:00	\N	\N
4698	24	VIDAL RAMOS	2010-03-11 00:00:00	\N	\N
4699	24	VIDEIRA	2010-03-11 00:00:00	\N	\N
4700	24	VITOR MEIRELES	2010-03-11 00:00:00	\N	\N
4701	24	WITTMARSUM	2010-03-11 00:00:00	\N	\N
4702	24	XANXERÊ	2010-03-11 00:00:00	\N	\N
4703	24	XAVANTINA	2010-03-11 00:00:00	\N	\N
4704	24	XAXIM	2010-03-11 00:00:00	\N	\N
4705	24	ZORTÉA	2010-03-11 00:00:00	\N	\N
4706	25	AMPARO DE SÃO FRANCISCO	2010-03-11 00:00:00	\N	\N
4707	25	AQUIDABÃ	2010-03-11 00:00:00	\N	\N
4708	25	ARACAJU	2010-03-11 00:00:00	\N	\N
4709	25	ARAUA	2010-03-11 00:00:00	\N	\N
4710	25	AREIA BRANCA	2010-03-11 00:00:00	\N	\N
4711	25	BARRA DOS COQUEIROS	2010-03-11 00:00:00	\N	\N
4712	25	BOQUIM	2010-03-11 00:00:00	\N	\N
4713	25	BREJO GRANDE	2010-03-11 00:00:00	\N	\N
4714	25	CAMPO DO BRITO	2010-03-11 00:00:00	\N	\N
4715	25	CANHOBA	2010-03-11 00:00:00	\N	\N
4716	25	CANINDÉ DE SÃO FRANCISCO	2010-03-11 00:00:00	\N	\N
4717	25	CAPELA	2010-03-11 00:00:00	\N	\N
4718	25	CARIRA	2010-03-11 00:00:00	\N	\N
4719	25	CARMÓPOLIS	2010-03-11 00:00:00	\N	\N
4720	25	CEDRO DE SÃO JOÃO	2010-03-11 00:00:00	\N	\N
4721	25	CRISTINÁPOLIS	2010-03-11 00:00:00	\N	\N
4722	25	CUMBE	2010-03-11 00:00:00	\N	\N
4723	25	DIVINA PASTORA	2010-03-11 00:00:00	\N	\N
4724	25	ESTÂNCIA	2010-03-11 00:00:00	\N	\N
4725	25	FEIRA NOVA	2010-03-11 00:00:00	\N	\N
4726	25	FREI PAULO	2010-03-11 00:00:00	\N	\N
4727	25	GARARU	2010-03-11 00:00:00	\N	\N
4728	25	GENERAL MAYNARD	2010-03-11 00:00:00	\N	\N
4729	25	GRACHO CARDOSO	2010-03-11 00:00:00	\N	\N
4730	25	ILHA DAS FLORES	2010-03-11 00:00:00	\N	\N
4731	25	INDIAROBA	2010-03-11 00:00:00	\N	\N
4732	25	ITABAIANA	2010-03-11 00:00:00	\N	\N
4733	25	ITABAIANINHA	2010-03-11 00:00:00	\N	\N
4734	25	ITABI	2010-03-11 00:00:00	\N	\N
4735	25	ITAPORANGA D AJUDA	2010-03-11 00:00:00	\N	\N
4736	25	JAPARATUBA	2010-03-11 00:00:00	\N	\N
4737	25	JAPOATÃ	2010-03-11 00:00:00	\N	\N
4738	25	LAGARTO	2010-03-11 00:00:00	\N	\N
4739	25	LARANJEIRAS	2010-03-11 00:00:00	\N	\N
4740	25	MACAMBIRA	2010-03-11 00:00:00	\N	\N
4741	25	MALHADA DOS BOIS	2010-03-11 00:00:00	\N	\N
4742	25	MALHADOR	2010-03-11 00:00:00	\N	\N
4743	25	MARUIM	2010-03-11 00:00:00	\N	\N
4744	25	MOITA BONITA	2010-03-11 00:00:00	\N	\N
4745	25	MONTE ALEGRE DE SERGIPE	2010-03-11 00:00:00	\N	\N
4746	25	MURIBECA	2010-03-11 00:00:00	\N	\N
4747	25	NEÓPOLIS	2010-03-11 00:00:00	\N	\N
4748	25	NOSSA SENHORA APARECIDA	2010-03-11 00:00:00	\N	\N
4749	25	NOSSA SENHORA DA GLÓRIA	2010-03-11 00:00:00	\N	\N
4750	25	NOSSA SENHORA DAS DORES	2010-03-11 00:00:00	\N	\N
4751	25	NOSSA SENHORA DE LOURDES	2010-03-11 00:00:00	\N	\N
4752	25	NOSSA SENHORA DO SOCORRO	2010-03-11 00:00:00	\N	\N
4753	25	PACATUBA	2010-03-11 00:00:00	\N	\N
4754	25	PEDRA MOLE	2010-03-11 00:00:00	\N	\N
4755	25	PEDRINHAS	2010-03-11 00:00:00	\N	\N
4756	25	PINHÃO	2010-03-11 00:00:00	\N	\N
4757	25	PIRAMBU	2010-03-11 00:00:00	\N	\N
4758	25	POÇO REDONDO	2010-03-11 00:00:00	\N	\N
4759	25	POÇO VERDE	2010-03-11 00:00:00	\N	\N
4760	25	PORTO DA FOLHA	2010-03-11 00:00:00	\N	\N
4761	25	PROPRIÁ	2010-03-11 00:00:00	\N	\N
4762	25	RIACHÃO DO DANTAS	2010-03-11 00:00:00	\N	\N
4763	25	RIACHUELO	2010-03-11 00:00:00	\N	\N
4764	25	RIBEIROPÓLIS	2010-03-11 00:00:00	\N	\N
4765	25	ROSÁRIO DO CATETE	2010-03-11 00:00:00	\N	\N
4766	25	SALGADO	2010-03-11 00:00:00	\N	\N
4767	25	SANTA LUZIA DO ITANHY	2010-03-11 00:00:00	\N	\N
4768	25	SANTA ROSA DE LIMA	2010-03-11 00:00:00	\N	\N
4769	25	SANTANA DE SÃO FRANCISCO	2010-03-11 00:00:00	\N	\N
4770	25	SANTO AMARO DAS BROTAS	2010-03-11 00:00:00	\N	\N
4771	25	SÃO CRISTÓVÃO	2010-03-11 00:00:00	\N	\N
4772	25	SÃO DOMINGOS	2010-03-11 00:00:00	\N	\N
4773	25	SÃO FRANCISCO	2010-03-11 00:00:00	\N	\N
4774	25	SÃO MIGUEL DO ALEIXO	2010-03-11 00:00:00	\N	\N
4775	25	SIMÃO DIAS	2010-03-11 00:00:00	\N	\N
4776	25	SIRIRI	2010-03-11 00:00:00	\N	\N
4777	25	TELHA	2010-03-11 00:00:00	\N	\N
4778	25	TOBIAS BARRETO	2010-03-11 00:00:00	\N	\N
4779	25	TOMAR DO GERU	2010-03-11 00:00:00	\N	\N
4780	25	UMBAÚBA	2010-03-11 00:00:00	\N	\N
4781	26	ADAMANTINA	2010-03-11 00:00:00	\N	\N
4782	26	ADOLFO	2010-03-11 00:00:00	\N	\N
4783	26	AGUAI	2010-03-11 00:00:00	\N	\N
4784	26	ÁGUAS DA PRATA	2010-03-11 00:00:00	\N	\N
4785	26	ÁGUAS DE LINDÓIA	2010-03-11 00:00:00	\N	\N
4786	26	ÁGUAS DE SANTA BÁRBARA	2010-03-11 00:00:00	\N	\N
4787	26	ÁGUAS DE SÃO PEDRO	2010-03-11 00:00:00	\N	\N
4788	26	AGUDOS	2010-03-11 00:00:00	\N	\N
4789	26	ALAMBARI	2010-03-11 00:00:00	\N	\N
4790	26	ALFREDO MARCONDES	2010-03-11 00:00:00	\N	\N
4791	26	ALTAIR	2010-03-11 00:00:00	\N	\N
4792	26	ALTINÓPOLIS	2010-03-11 00:00:00	\N	\N
4793	26	ALTO ALEGRE	2010-03-11 00:00:00	\N	\N
4794	26	ALUMÍNIO	2010-03-11 00:00:00	\N	\N
4795	26	ALVARES FLORENCE	2010-03-11 00:00:00	\N	\N
4796	26	ALVARES MACHADO	2010-03-11 00:00:00	\N	\N
4797	26	ÁLVARO DE CARVALHO	2010-03-11 00:00:00	\N	\N
4798	26	ALVINLÂNDIA	2010-03-11 00:00:00	\N	\N
4799	26	AMERICANA	2010-03-11 00:00:00	\N	\N
4800	26	AMÉRICO BRASILIENSE	2010-03-11 00:00:00	\N	\N
4801	26	AMÉRICO DE CAMPOS	2010-03-11 00:00:00	\N	\N
4802	26	AMPARO	2010-03-11 00:00:00	\N	\N
4803	26	ANALÂNDIA	2010-03-11 00:00:00	\N	\N
4804	26	ANDRADINA	2010-03-11 00:00:00	\N	\N
4805	26	ANGATUBA	2010-03-11 00:00:00	\N	\N
4806	26	ANHEMBI	2010-03-11 00:00:00	\N	\N
4807	26	ANHUMAS	2010-03-11 00:00:00	\N	\N
4808	26	APARECIDA	2010-03-11 00:00:00	\N	\N
4809	26	APARECIDA D OESTE	2010-03-11 00:00:00	\N	\N
4810	26	APIAÍ	2010-03-11 00:00:00	\N	\N
4811	26	ARAÇARIGUAMA	2010-03-11 00:00:00	\N	\N
4812	26	ARAÇATUBA	2010-03-11 00:00:00	\N	\N
4813	26	ARAÇOIABA DA SERRA	2010-03-11 00:00:00	\N	\N
4814	26	ARAMINA	2010-03-11 00:00:00	\N	\N
4815	26	ARANDU	2010-03-11 00:00:00	\N	\N
4816	26	ARAPEÍ	2010-03-11 00:00:00	\N	\N
4817	26	ARARAQUARA	2010-03-11 00:00:00	\N	\N
4818	26	ARARAS	2010-03-11 00:00:00	\N	\N
4819	26	ARCO-ÍRIS	2010-03-11 00:00:00	\N	\N
4820	26	AREALVA	2010-03-11 00:00:00	\N	\N
4821	26	AREIAS	2010-03-11 00:00:00	\N	\N
4822	26	AREIÓPOLIS	2010-03-11 00:00:00	\N	\N
4823	26	ARIRANHA	2010-03-11 00:00:00	\N	\N
4824	26	ARTUR NOGUEIRA	2010-03-11 00:00:00	\N	\N
4825	26	ARUJÁ	2010-03-11 00:00:00	\N	\N
4826	26	ASPÁSIA	2010-03-11 00:00:00	\N	\N
4827	26	ASSIS	2010-03-11 00:00:00	\N	\N
4828	26	ATIBAIA	2010-03-11 00:00:00	\N	\N
4829	26	AURIFLAMA	2010-03-11 00:00:00	\N	\N
4830	26	AVAÍ	2010-03-11 00:00:00	\N	\N
4831	26	AVANHANDAVA	2010-03-11 00:00:00	\N	\N
4832	26	AVARÉ	2010-03-11 00:00:00	\N	\N
4833	26	BADY BASSITT	2010-03-11 00:00:00	\N	\N
4834	26	BALBINOS	2010-03-11 00:00:00	\N	\N
4835	26	BÁLSAMO	2010-03-11 00:00:00	\N	\N
4836	26	BANANAL	2010-03-11 00:00:00	\N	\N
4837	26	BARÃO DE ANTONINA	2010-03-11 00:00:00	\N	\N
4838	26	BARBOSA	2010-03-11 00:00:00	\N	\N
4839	26	BARIRI	2010-03-11 00:00:00	\N	\N
4840	26	BARRA BONITA	2010-03-11 00:00:00	\N	\N
4841	26	BARRA DO CHAPÉU	2010-03-11 00:00:00	\N	\N
4842	26	BARRA DO TURVO	2010-03-11 00:00:00	\N	\N
4843	26	BARRETOS	2010-03-11 00:00:00	\N	\N
4844	26	BARRINHA	2010-03-11 00:00:00	\N	\N
4845	26	BARUERI	2010-03-11 00:00:00	\N	\N
4846	26	BASTOS	2010-03-11 00:00:00	\N	\N
4847	26	BATATAIS	2010-03-11 00:00:00	\N	\N
4848	26	BAURU	2010-03-11 00:00:00	\N	\N
4849	26	BEBEDOURO	2010-03-11 00:00:00	\N	\N
4850	26	BENTO DE ABREU	2010-03-11 00:00:00	\N	\N
4851	26	BERNARDINO DE CAMPOS	2010-03-11 00:00:00	\N	\N
4852	26	BERTIOGA	2010-03-11 00:00:00	\N	\N
4853	26	BILAC	2010-03-11 00:00:00	\N	\N
4854	26	BIRIGUI	2010-03-11 00:00:00	\N	\N
4855	26	BIRITIBA-MIRIM	2010-03-11 00:00:00	\N	\N
4856	26	BOA ESPERANÇA DO SUL	2010-03-11 00:00:00	\N	\N
4857	26	BOCAINA	2010-03-11 00:00:00	\N	\N
4858	26	BOFETE	2010-03-11 00:00:00	\N	\N
4859	26	BOITUVA	2010-03-11 00:00:00	\N	\N
4860	26	BOM JESUS DOS PERDÕES	2010-03-11 00:00:00	\N	\N
4861	26	BOM SUCESSO DE ITARARÉ	2010-03-11 00:00:00	\N	\N
4862	26	BORÁ	2010-03-11 00:00:00	\N	\N
4863	26	BORACÉIA	2010-03-11 00:00:00	\N	\N
4864	26	BORBOREMA	2010-03-11 00:00:00	\N	\N
4865	26	BOREBI	2010-03-11 00:00:00	\N	\N
4866	26	BOTUCATU	2010-03-11 00:00:00	\N	\N
4867	26	BRAGANÇA PAULISTA	2010-03-11 00:00:00	\N	\N
4868	26	BRAÚNA	2010-03-11 00:00:00	\N	\N
4869	26	BREJO ALEGRE	2010-03-11 00:00:00	\N	\N
4870	26	BRODOSQUI	2010-03-11 00:00:00	\N	\N
4871	26	BROTAS	2010-03-11 00:00:00	\N	\N
4872	26	BURI	2010-03-11 00:00:00	\N	\N
4873	26	BURITAMA	2010-03-11 00:00:00	\N	\N
4874	26	BURITIZAL	2010-03-11 00:00:00	\N	\N
4875	26	CABRÁLIA PAULISTA	2010-03-11 00:00:00	\N	\N
4876	26	CABREÚVA	2010-03-11 00:00:00	\N	\N
4877	26	CAÇAPAVA	2010-03-11 00:00:00	\N	\N
4878	26	CACHOEIRA PAULISTA	2010-03-11 00:00:00	\N	\N
4879	26	CACONDE	2010-03-11 00:00:00	\N	\N
4880	26	CAFELÂNDIA	2010-03-11 00:00:00	\N	\N
4881	26	CAIABU	2010-03-11 00:00:00	\N	\N
4882	26	CAIEIRAS	2010-03-11 00:00:00	\N	\N
4883	26	CAIUA	2010-03-11 00:00:00	\N	\N
4884	26	CAJAMAR	2010-03-11 00:00:00	\N	\N
4885	26	CAJATI	2010-03-11 00:00:00	\N	\N
4886	26	CAJOBI	2010-03-11 00:00:00	\N	\N
4887	26	CAJURU	2010-03-11 00:00:00	\N	\N
4888	26	CAMPINA DO MONTE ALEGRE	2010-03-11 00:00:00	\N	\N
4889	26	CAMPINAS	2010-03-11 00:00:00	\N	\N
4890	26	CAMPO LIMPO PAULISTA	2010-03-11 00:00:00	\N	\N
4891	26	CAMPOS DO JORDÃO	2010-03-11 00:00:00	\N	\N
4892	26	CAMPOS NOVOS PAULISTA	2010-03-11 00:00:00	\N	\N
4893	26	CANANÉIA	2010-03-11 00:00:00	\N	\N
4894	26	CANAS	2010-03-11 00:00:00	\N	\N
4895	26	CÂNDIDO MOTA	2010-03-11 00:00:00	\N	\N
4896	26	CÂNDIDO RODRIGUES	2010-03-11 00:00:00	\N	\N
4897	26	CANITAR	2010-03-11 00:00:00	\N	\N
4898	26	CAPÃO BONITO	2010-03-11 00:00:00	\N	\N
4899	26	CAPELA DO ALTO	2010-03-11 00:00:00	\N	\N
4900	26	CAPIVARI	2010-03-11 00:00:00	\N	\N
4901	26	CARAGUATATUBA	2010-03-11 00:00:00	\N	\N
4902	26	CARAPICUÍBA	2010-03-11 00:00:00	\N	\N
4903	26	CARDOSO	2010-03-11 00:00:00	\N	\N
4904	26	CASA BRANCA	2010-03-11 00:00:00	\N	\N
4905	26	CÁSSIA DOS COQUEIROS	2010-03-11 00:00:00	\N	\N
4906	26	CASTILHO	2010-03-11 00:00:00	\N	\N
4907	26	CATANDUVA	2010-03-11 00:00:00	\N	\N
4908	26	CATIGUÁ	2010-03-11 00:00:00	\N	\N
4909	26	CEDRAL	2010-03-11 00:00:00	\N	\N
4910	26	CERQUEIRA CÉSAR	2010-03-11 00:00:00	\N	\N
4911	26	CERQUILHO	2010-03-11 00:00:00	\N	\N
4912	26	CESÁRIO LANGE	2010-03-11 00:00:00	\N	\N
4913	26	CHARQUEADA	2010-03-11 00:00:00	\N	\N
4914	26	CHAVANTES	2010-03-11 00:00:00	\N	\N
4915	26	CLEMENTINA	2010-03-11 00:00:00	\N	\N
4916	26	COLINA	2010-03-11 00:00:00	\N	\N
4917	26	COLÔMBIA	2010-03-11 00:00:00	\N	\N
4918	26	CONCHAL	2010-03-11 00:00:00	\N	\N
4919	26	CONCHAS	2010-03-11 00:00:00	\N	\N
4920	26	CORDEIRÓPOLIS	2010-03-11 00:00:00	\N	\N
4921	26	COROADOS	2010-03-11 00:00:00	\N	\N
4922	26	CORONEL MACEDO	2010-03-11 00:00:00	\N	\N
4923	26	CORUMBATAI	2010-03-11 00:00:00	\N	\N
4924	26	COSMÓPOLIS	2010-03-11 00:00:00	\N	\N
4925	26	COSMORAMA	2010-03-11 00:00:00	\N	\N
4926	26	COTIA	2010-03-11 00:00:00	\N	\N
4927	26	CRAVINHOS	2010-03-11 00:00:00	\N	\N
4928	26	CRISTAIS PAULISTA	2010-03-11 00:00:00	\N	\N
4929	26	CRUZÁLIA	2010-03-11 00:00:00	\N	\N
4930	26	CRUZEIRO	2010-03-11 00:00:00	\N	\N
4931	26	CUBATÃO	2010-03-11 00:00:00	\N	\N
4932	26	CUNHA	2010-03-11 00:00:00	\N	\N
4933	26	DESCALVADO	2010-03-11 00:00:00	\N	\N
4934	26	DIADEMA	2010-03-11 00:00:00	\N	\N
4935	26	DIRCE REIS	2010-03-11 00:00:00	\N	\N
4936	26	DIVINOLÂNDIA	2010-03-11 00:00:00	\N	\N
4937	26	DOBRADA	2010-03-11 00:00:00	\N	\N
4938	26	DOIS CÓRREGOS	2010-03-11 00:00:00	\N	\N
4939	26	DOLCINÓPOLIS	2010-03-11 00:00:00	\N	\N
4940	26	DOURADO	2010-03-11 00:00:00	\N	\N
4941	26	DRACENA	2010-03-11 00:00:00	\N	\N
4942	26	DUARTINA	2010-03-11 00:00:00	\N	\N
4943	26	DUMONT	2010-03-11 00:00:00	\N	\N
4944	26	ECHAPORÃ	2010-03-11 00:00:00	\N	\N
4945	26	ELDORADO	2010-03-11 00:00:00	\N	\N
4946	26	ELIAS FAUSTO	2010-03-11 00:00:00	\N	\N
4947	26	ELISIÁRIO	2010-03-11 00:00:00	\N	\N
4948	26	EMBAÚBA	2010-03-11 00:00:00	\N	\N
4949	26	EMBU	2010-03-11 00:00:00	\N	\N
4950	26	EMBU-GUAÇU	2010-03-11 00:00:00	\N	\N
4951	26	EMILIANÓPOLIS	2010-03-11 00:00:00	\N	\N
4952	26	ENGENHEIRO COELHO	2010-03-11 00:00:00	\N	\N
4953	26	ESPÍRITO SANTO DO PINHAL	2010-03-11 00:00:00	\N	\N
4954	26	ESPÍRITO SANTO DO TURVO	2010-03-11 00:00:00	\N	\N
4955	26	ESTIVA GERBI	2010-03-11 00:00:00	\N	\N
4956	26	ESTRELA D OESTE	2010-03-11 00:00:00	\N	\N
4957	26	ESTRELA DO NORTE	2010-03-11 00:00:00	\N	\N
4958	26	EUCLIDES DA CUNHA PAULISTA	2010-03-11 00:00:00	\N	\N
4959	26	FARTURA	2010-03-11 00:00:00	\N	\N
4960	26	FERNANDO PRESTES	2010-03-11 00:00:00	\N	\N
4961	26	FERNANDÓPOLIS	2010-03-11 00:00:00	\N	\N
4962	26	FERNÃO	2010-03-11 00:00:00	\N	\N
4963	26	FERRAZ DE VASCONCELOS	2010-03-11 00:00:00	\N	\N
4964	26	FLORA RICA	2010-03-11 00:00:00	\N	\N
4965	26	FLOREAL	2010-03-11 00:00:00	\N	\N
4966	26	FLÓRIDA PAULISTA	2010-03-11 00:00:00	\N	\N
4967	26	FLORÍNIA	2010-03-11 00:00:00	\N	\N
4968	26	FRANCA	2010-03-11 00:00:00	\N	\N
4969	26	FRANCISCO MORATO	2010-03-11 00:00:00	\N	\N
4970	26	FRANCO DA ROCHA	2010-03-11 00:00:00	\N	\N
4971	26	GABRIEL MONTEIRO	2010-03-11 00:00:00	\N	\N
4972	26	GÁLIA	2010-03-11 00:00:00	\N	\N
4973	26	GARÇA	2010-03-11 00:00:00	\N	\N
4974	26	GASTÃO VIDIGAL	2010-03-11 00:00:00	\N	\N
4975	26	GAVIÃO PEIXOTO	2010-03-11 00:00:00	\N	\N
4976	26	GENERAL SALGADO	2010-03-11 00:00:00	\N	\N
4977	26	GETULINA	2010-03-11 00:00:00	\N	\N
4978	26	GLICÉRIO	2010-03-11 00:00:00	\N	\N
4979	26	GUAIÇARA	2010-03-11 00:00:00	\N	\N
4980	26	GUAIMBÉ	2010-03-11 00:00:00	\N	\N
4981	26	GUAÍRA	2010-03-11 00:00:00	\N	\N
4982	26	GUAPIAÇU	2010-03-11 00:00:00	\N	\N
4983	26	GUAPIARA	2010-03-11 00:00:00	\N	\N
4984	26	GUARÁ	2010-03-11 00:00:00	\N	\N
4985	26	GUARAÇAÍ	2010-03-11 00:00:00	\N	\N
4986	26	GUARACI	2010-03-11 00:00:00	\N	\N
4987	26	GUARANI D OESTE	2010-03-11 00:00:00	\N	\N
4988	26	GUARANTÃ	2010-03-11 00:00:00	\N	\N
4989	26	GUARAPARES	2010-03-11 00:00:00	\N	\N
4990	26	GUARAREMA	2010-03-11 00:00:00	\N	\N
4991	26	GUARATINGUETÁ	2010-03-11 00:00:00	\N	\N
4992	26	GUAREÍ	2010-03-11 00:00:00	\N	\N
4993	26	GUARIBA	2010-03-11 00:00:00	\N	\N
4994	26	GUARUJÁ	2010-03-11 00:00:00	\N	\N
4995	26	GUARULHOS	2010-03-11 00:00:00	\N	\N
4996	26	GUATAPARA	2010-03-11 00:00:00	\N	\N
4997	26	GUZOLÂNDIA	2010-03-11 00:00:00	\N	\N
4998	26	HERCULÂNDIA	2010-03-11 00:00:00	\N	\N
4999	26	HOLAMBRA	2010-03-11 00:00:00	\N	\N
5000	26	HORTOLÂNDIA	2010-03-11 00:00:00	\N	\N
5001	26	IACANGA	2010-03-11 00:00:00	\N	\N
5002	26	IACRI	2010-03-11 00:00:00	\N	\N
5003	26	IARAS	2010-03-11 00:00:00	\N	\N
5004	26	IBATE	2010-03-11 00:00:00	\N	\N
5005	26	IBIRA	2010-03-11 00:00:00	\N	\N
5006	26	IBIRAREMA	2010-03-11 00:00:00	\N	\N
5007	26	IBITINGA	2010-03-11 00:00:00	\N	\N
5008	26	IBIUNA	2010-03-11 00:00:00	\N	\N
5009	26	ICEM	2010-03-11 00:00:00	\N	\N
5010	26	IEPÊ	2010-03-11 00:00:00	\N	\N
5011	26	IGARAÇU DO TIETÊ	2010-03-11 00:00:00	\N	\N
5012	26	IGARAPAVA	2010-03-11 00:00:00	\N	\N
5013	26	IGARATÁ	2010-03-11 00:00:00	\N	\N
5014	26	IGUAPE	2010-03-11 00:00:00	\N	\N
5015	26	ILHA COMPRIDA	2010-03-11 00:00:00	\N	\N
5016	26	ILHA SOLTEIRA	2010-03-11 00:00:00	\N	\N
5017	26	ILHABELA	2010-03-11 00:00:00	\N	\N
5018	26	INDAIATUBA	2010-03-11 00:00:00	\N	\N
5019	26	INDIANA	2010-03-11 00:00:00	\N	\N
5020	26	INDIAPORÃ	2010-03-11 00:00:00	\N	\N
5021	26	INÚBIA PAULISTA	2010-03-11 00:00:00	\N	\N
5022	26	IPAUSSU	2010-03-11 00:00:00	\N	\N
5023	26	IPERÓ	2010-03-11 00:00:00	\N	\N
5024	26	IPEUNA	2010-03-11 00:00:00	\N	\N
5025	26	IPIGUÁ	2010-03-11 00:00:00	\N	\N
5026	26	IPORANGA	2010-03-11 00:00:00	\N	\N
5027	26	IPUÃ	2010-03-11 00:00:00	\N	\N
5028	26	IRACEMÁPOLIS	2010-03-11 00:00:00	\N	\N
5029	26	IRAPUÃ	2010-03-11 00:00:00	\N	\N
5030	26	IRAPURU	2010-03-11 00:00:00	\N	\N
5031	26	ITABERA	2010-03-11 00:00:00	\N	\N
5032	26	ITAÍ	2010-03-11 00:00:00	\N	\N
5033	26	ITAJOBI	2010-03-11 00:00:00	\N	\N
5034	26	ITAJU	2010-03-11 00:00:00	\N	\N
5035	26	ITANHAEM	2010-03-11 00:00:00	\N	\N
5036	26	ITAÓCA	2010-03-11 00:00:00	\N	\N
5037	26	ITAPECERICA DA SERRA	2010-03-11 00:00:00	\N	\N
5038	26	ITAPETININGA	2010-03-11 00:00:00	\N	\N
5039	26	ITAPEVA	2010-03-11 00:00:00	\N	\N
5040	26	ITAPEVI	2010-03-11 00:00:00	\N	\N
5041	26	ITAPIRA	2010-03-11 00:00:00	\N	\N
5042	26	ITAPIRAPUÃ PAULISTA	2010-03-11 00:00:00	\N	\N
5043	26	ITÁPOLIS	2010-03-11 00:00:00	\N	\N
5044	26	ITAPORANGA	2010-03-11 00:00:00	\N	\N
5045	26	ITAPUI	2010-03-11 00:00:00	\N	\N
5046	26	ITAPURA	2010-03-11 00:00:00	\N	\N
5047	26	ITAQUAQUECETUBA	2010-03-11 00:00:00	\N	\N
5048	26	ITARARÉ	2010-03-11 00:00:00	\N	\N
5049	26	ITARIRI	2010-03-11 00:00:00	\N	\N
5050	26	ITATIBA	2010-03-11 00:00:00	\N	\N
5051	26	ITATINGA	2010-03-11 00:00:00	\N	\N
5052	26	ITIRAPINA	2010-03-11 00:00:00	\N	\N
5053	26	ITIRAPUÃ	2010-03-11 00:00:00	\N	\N
5054	26	ITOBI	2010-03-11 00:00:00	\N	\N
5055	26	ITU	2010-03-11 00:00:00	\N	\N
5056	26	ITUPEVA	2010-03-11 00:00:00	\N	\N
5057	26	ITUVERAVA	2010-03-11 00:00:00	\N	\N
5058	26	JABORANDI	2010-03-11 00:00:00	\N	\N
5059	26	JABOTICABAL	2010-03-11 00:00:00	\N	\N
5060	26	JACAREÍ	2010-03-11 00:00:00	\N	\N
5061	26	JACI	2010-03-11 00:00:00	\N	\N
5062	26	JACUPIRANGA	2010-03-11 00:00:00	\N	\N
5063	26	JAGUARIÚNA	2010-03-11 00:00:00	\N	\N
5064	26	JALES	2010-03-11 00:00:00	\N	\N
5065	26	JAMBEIRO	2010-03-11 00:00:00	\N	\N
5066	26	JANDIRA	2010-03-11 00:00:00	\N	\N
5067	26	JARDINÓPOLIS	2010-03-11 00:00:00	\N	\N
5068	26	JARINU	2010-03-11 00:00:00	\N	\N
5069	26	JAÚ	2010-03-11 00:00:00	\N	\N
5070	26	JERIQUARA	2010-03-11 00:00:00	\N	\N
5071	26	JOANÓPOLIS	2010-03-11 00:00:00	\N	\N
5072	26	JOÃO RAMALHO	2010-03-11 00:00:00	\N	\N
5073	26	JOSÉ BONIFÁCIO	2010-03-11 00:00:00	\N	\N
5074	26	JÚLIO MESQUITA	2010-03-11 00:00:00	\N	\N
5075	26	JUMIRIM	2010-03-11 00:00:00	\N	\N
5076	26	JUNDIAÍ	2010-03-11 00:00:00	\N	\N
5077	26	JUNQUEIRÓPOLIS	2010-03-11 00:00:00	\N	\N
5078	26	JUQUIÁ	2010-03-11 00:00:00	\N	\N
5079	26	JUQUITIBA	2010-03-11 00:00:00	\N	\N
5080	26	LAGOINHA	2010-03-11 00:00:00	\N	\N
5081	26	LARANJAL PAULISTA	2010-03-11 00:00:00	\N	\N
5082	26	LAVÍNIA	2010-03-11 00:00:00	\N	\N
5083	26	LAVRINHAS	2010-03-11 00:00:00	\N	\N
5084	26	LEME	2010-03-11 00:00:00	\N	\N
5085	26	LENÇÓIS PAULISTA	2010-03-11 00:00:00	\N	\N
5086	26	LIMEIRA	2010-03-11 00:00:00	\N	\N
5087	26	LINDÓIA	2010-03-11 00:00:00	\N	\N
5088	26	LINS	2010-03-11 00:00:00	\N	\N
5089	26	LORENA	2010-03-11 00:00:00	\N	\N
5090	26	LOURDES	2010-03-11 00:00:00	\N	\N
5091	26	LOUVEIRA	2010-03-11 00:00:00	\N	\N
5092	26	LUCÉLIA	2010-03-11 00:00:00	\N	\N
5093	26	LUCIANÓPOLIS	2010-03-11 00:00:00	\N	\N
5094	26	LUIS ANTÔNIO	2010-03-11 00:00:00	\N	\N
5095	26	LUIZIÂNIA	2010-03-11 00:00:00	\N	\N
5096	26	LUPÉRCIO	2010-03-11 00:00:00	\N	\N
5097	26	LUTÉCIA	2010-03-11 00:00:00	\N	\N
5098	26	MACATUBA	2010-03-11 00:00:00	\N	\N
5099	26	MACAUBAL	2010-03-11 00:00:00	\N	\N
5100	26	MACEDÔNIA	2010-03-11 00:00:00	\N	\N
5101	26	MAGDA	2010-03-11 00:00:00	\N	\N
5102	26	MAIRINQUE	2010-03-11 00:00:00	\N	\N
5103	26	MAIRIPORÃ	2010-03-11 00:00:00	\N	\N
5104	26	MANDURI	2010-03-11 00:00:00	\N	\N
5105	26	MARABÁ PAULISTA	2010-03-11 00:00:00	\N	\N
5106	26	MARACAÍ	2010-03-11 00:00:00	\N	\N
5107	26	MARAPOAMA	2010-03-11 00:00:00	\N	\N
5108	26	MARIÁPOLIS	2010-03-11 00:00:00	\N	\N
5109	26	MARÍLIA	2010-03-11 00:00:00	\N	\N
5110	26	MARINÓPOLIS	2010-03-11 00:00:00	\N	\N
5111	26	MARTINÓPOLIS	2010-03-11 00:00:00	\N	\N
5112	26	MATÃO	2010-03-11 00:00:00	\N	\N
5113	26	MAUÁ	2010-03-11 00:00:00	\N	\N
5114	26	MENDONÇA	2010-03-11 00:00:00	\N	\N
5115	26	MERIDIANO	2010-03-11 00:00:00	\N	\N
5116	26	MESÓPOLIS	2010-03-11 00:00:00	\N	\N
5117	26	MIGUELÓPOLIS	2010-03-11 00:00:00	\N	\N
5118	26	MINEIROS DO TIETÊ	2010-03-11 00:00:00	\N	\N
5119	26	MIRA ESTRELA	2010-03-11 00:00:00	\N	\N
5120	26	MIRACATU	2010-03-11 00:00:00	\N	\N
5121	26	MIRANDÓPOLIS	2010-03-11 00:00:00	\N	\N
5122	26	MIRANTE DO PARANAPANEMA	2010-03-11 00:00:00	\N	\N
5123	26	MIRASSOL	2010-03-11 00:00:00	\N	\N
5124	26	MIRASSOLÂNDIA	2010-03-11 00:00:00	\N	\N
5125	26	MOCOCA	2010-03-11 00:00:00	\N	\N
5126	26	MOJI DAS CRUZES	2010-03-11 00:00:00	\N	\N
5127	26	MOJI-GUAÇU	2010-03-11 00:00:00	\N	\N
5128	26	MOJI-MIRIM	2010-03-11 00:00:00	\N	\N
5129	26	MOMBUCA	2010-03-11 00:00:00	\N	\N
5130	26	MONÇÕES	2010-03-11 00:00:00	\N	\N
5131	26	MONGAGUÁ	2010-03-11 00:00:00	\N	\N
5132	26	MONTE ALEGRE DO SUL	2010-03-11 00:00:00	\N	\N
5133	26	MONTE ALTO	2010-03-11 00:00:00	\N	\N
5134	26	MONTE APRAZÍVEL	2010-03-11 00:00:00	\N	\N
5135	26	MONTE AZUL PAULISTA	2010-03-11 00:00:00	\N	\N
5136	26	MONTE CASTELO	2010-03-11 00:00:00	\N	\N
5137	26	MONTE MOR	2010-03-11 00:00:00	\N	\N
5138	26	MONTEIRO LOBATO	2010-03-11 00:00:00	\N	\N
5139	26	MORRO AGUDO	2010-03-11 00:00:00	\N	\N
5140	26	MORUNGABA	2010-03-11 00:00:00	\N	\N
5141	26	MOTUCA	2010-03-11 00:00:00	\N	\N
5142	26	MURUTINGA DO SUL	2010-03-11 00:00:00	\N	\N
5143	26	NANTES	2010-03-11 00:00:00	\N	\N
5144	26	NARANDIBA	2010-03-11 00:00:00	\N	\N
5145	26	NATIVIDADE DA SERRA	2010-03-11 00:00:00	\N	\N
5146	26	NAZARÉ PAULISTA	2010-03-11 00:00:00	\N	\N
5147	26	NEVES PAULISTA	2010-03-11 00:00:00	\N	\N
5148	26	NHANDEARA	2010-03-11 00:00:00	\N	\N
5149	26	NIPOÃ	2010-03-11 00:00:00	\N	\N
5150	26	NOVA ALIANÇA	2010-03-11 00:00:00	\N	\N
5151	26	NOVA CAMPINA	2010-03-11 00:00:00	\N	\N
5152	26	NOVA CANAÃ PAULISTA	2010-03-11 00:00:00	\N	\N
5153	26	NOVA CASTILHO	2010-03-11 00:00:00	\N	\N
5154	26	NOVA EUROPA	2010-03-11 00:00:00	\N	\N
5155	26	NOVA GRANADA	2010-03-11 00:00:00	\N	\N
5156	26	NOVA GUATAPORANGA	2010-03-11 00:00:00	\N	\N
5157	26	NOVA INDEPENDÊNCIA	2010-03-11 00:00:00	\N	\N
5158	26	NOVA LUZITÂNIA	2010-03-11 00:00:00	\N	\N
5159	26	NOVA ODESSA	2010-03-11 00:00:00	\N	\N
5160	26	NOVAIS	2010-03-11 00:00:00	\N	\N
5161	26	NOVO HORIZONTE	2010-03-11 00:00:00	\N	\N
5162	26	NUPORANGA	2010-03-11 00:00:00	\N	\N
5163	26	OCAUÇU	2010-03-11 00:00:00	\N	\N
5164	26	ÓLEO	2010-03-11 00:00:00	\N	\N
5165	26	OLÍMPIA	2010-03-11 00:00:00	\N	\N
5166	26	ONDA VERDE	2010-03-11 00:00:00	\N	\N
5167	26	ORIENTE	2010-03-11 00:00:00	\N	\N
5168	26	ORINDIUVA	2010-03-11 00:00:00	\N	\N
5169	26	ORLÂNDIA	2010-03-11 00:00:00	\N	\N
5170	26	OSASCO	2010-03-11 00:00:00	\N	\N
5171	26	OSCAR BRESSANE	2010-03-11 00:00:00	\N	\N
5172	26	OSVALDO CRUZ	2010-03-11 00:00:00	\N	\N
5173	26	OURINHOS	2010-03-11 00:00:00	\N	\N
5174	26	OURO VERDE	2010-03-11 00:00:00	\N	\N
5175	26	OUROESTE	2010-03-11 00:00:00	\N	\N
5176	26	PACAEMBU	2010-03-11 00:00:00	\N	\N
5177	26	PALESTINA	2010-03-11 00:00:00	\N	\N
5178	26	PALMARES PAULISTA	2010-03-11 00:00:00	\N	\N
5179	26	PALMEIRA D OESTE	2010-03-11 00:00:00	\N	\N
5180	26	PALMITAL	2010-03-11 00:00:00	\N	\N
5181	26	PANORAMA	2010-03-11 00:00:00	\N	\N
5182	26	PARAGUAÇU PAULISTA	2010-03-11 00:00:00	\N	\N
5183	26	PARAIBUNA	2010-03-11 00:00:00	\N	\N
5184	26	PARAÍSO	2010-03-11 00:00:00	\N	\N
5185	26	PARANAPANEMA	2010-03-11 00:00:00	\N	\N
5186	26	PARANAPUÃ	2010-03-11 00:00:00	\N	\N
5187	26	PARAPUÃ	2010-03-11 00:00:00	\N	\N
5188	26	PARDINHO	2010-03-11 00:00:00	\N	\N
5189	26	PARIQUERA-AÇU	2010-03-11 00:00:00	\N	\N
5190	26	PARISI	2010-03-11 00:00:00	\N	\N
5191	26	PATROCÍNIO PAULISTA	2010-03-11 00:00:00	\N	\N
5192	26	PAULICÉIA	2010-03-11 00:00:00	\N	\N
5193	26	PAULÍNIA	2010-03-11 00:00:00	\N	\N
5194	26	PAULISTÂNIA	2010-03-11 00:00:00	\N	\N
5195	26	PAULO DE FARIA	2010-03-11 00:00:00	\N	\N
5196	26	PEDERNEIRAS	2010-03-11 00:00:00	\N	\N
5197	26	PEDRA BELA	2010-03-11 00:00:00	\N	\N
5198	26	PEDRANÓPOLIS	2010-03-11 00:00:00	\N	\N
5199	26	PEDREGULHO	2010-03-11 00:00:00	\N	\N
5200	26	PEDREIRA	2010-03-11 00:00:00	\N	\N
5201	26	PEDRINHAS PAULISTA	2010-03-11 00:00:00	\N	\N
5202	26	PEDRO DE TOLEDO	2010-03-11 00:00:00	\N	\N
5203	26	PENÁPOLIS	2010-03-11 00:00:00	\N	\N
5204	26	PEREIRA BARRETO	2010-03-11 00:00:00	\N	\N
5205	26	PEREIRAS	2010-03-11 00:00:00	\N	\N
5206	26	PERUÍBE	2010-03-11 00:00:00	\N	\N
5207	26	PIACATU	2010-03-11 00:00:00	\N	\N
5208	26	PIEDADE	2010-03-11 00:00:00	\N	\N
5209	26	PILAR DO SUL	2010-03-11 00:00:00	\N	\N
5210	26	PINDAMONHANGABA	2010-03-11 00:00:00	\N	\N
5211	26	PINDORAMA	2010-03-11 00:00:00	\N	\N
5212	26	PINHALZINHO	2010-03-11 00:00:00	\N	\N
5213	26	PIQUEROBI	2010-03-11 00:00:00	\N	\N
5214	26	PIQUETE	2010-03-11 00:00:00	\N	\N
5215	26	PIRACAIA	2010-03-11 00:00:00	\N	\N
5216	26	PIRACICABA	2010-03-11 00:00:00	\N	\N
5217	26	PIRAJU	2010-03-11 00:00:00	\N	\N
5218	26	PIRAJUÍ	2010-03-11 00:00:00	\N	\N
5219	26	PIRANGI	2010-03-11 00:00:00	\N	\N
5220	26	PIRAPORA DO BOM JESUS	2010-03-11 00:00:00	\N	\N
5221	26	PIRAPOZINHO	2010-03-11 00:00:00	\N	\N
5222	26	PIRASSUNUNGA	2010-03-11 00:00:00	\N	\N
5223	26	PIRATININGA	2010-03-11 00:00:00	\N	\N
5224	26	PITANGUEIRAS	2010-03-11 00:00:00	\N	\N
5225	26	PLANALTO	2010-03-11 00:00:00	\N	\N
5226	26	PLATINA	2010-03-11 00:00:00	\N	\N
5227	26	POÁ	2010-03-11 00:00:00	\N	\N
5228	26	POLONI	2010-03-11 00:00:00	\N	\N
5229	26	POMPÉIA	2010-03-11 00:00:00	\N	\N
5230	26	PONGAI	2010-03-11 00:00:00	\N	\N
5231	26	PONTAL	2010-03-11 00:00:00	\N	\N
5232	26	PONTALINDA	2010-03-11 00:00:00	\N	\N
5233	26	PONTES GESTAL	2010-03-11 00:00:00	\N	\N
5234	26	POPULINA	2010-03-11 00:00:00	\N	\N
5235	26	PORANGABA	2010-03-11 00:00:00	\N	\N
5236	26	PORTO FELIZ	2010-03-11 00:00:00	\N	\N
5237	26	PORTO FERREIRA	2010-03-11 00:00:00	\N	\N
5238	26	POTIM	2010-03-11 00:00:00	\N	\N
5239	26	POTIRENDABA	2010-03-11 00:00:00	\N	\N
5240	26	PRACINHA	2010-03-11 00:00:00	\N	\N
5241	26	PRADÓPOLIS	2010-03-11 00:00:00	\N	\N
5242	26	PRAIA GRANDE	2010-03-11 00:00:00	\N	\N
5243	26	PRATÂNIA	2010-03-11 00:00:00	\N	\N
5244	26	PRESIDENTE ALVES	2010-03-11 00:00:00	\N	\N
5245	26	PRESIDENTE BERNARDES	2010-03-11 00:00:00	\N	\N
5246	26	PRESIDENTE EPITÁCIO	2010-03-11 00:00:00	\N	\N
5247	26	PRESIDENTE PRUDENTE	2010-03-11 00:00:00	\N	\N
5248	26	PRESIDENTE VENCESLAU	2010-03-11 00:00:00	\N	\N
5249	26	PROMISSÃO	2010-03-11 00:00:00	\N	\N
5250	26	QUADRA	2010-03-11 00:00:00	\N	\N
5251	26	QUATÁ	2010-03-11 00:00:00	\N	\N
5252	26	QUEIROZ	2010-03-11 00:00:00	\N	\N
5253	26	QUELUZ	2010-03-11 00:00:00	\N	\N
5254	26	QUINTANA	2010-03-11 00:00:00	\N	\N
5255	26	RAFARD	2010-03-11 00:00:00	\N	\N
5256	26	RANCHARIA	2010-03-11 00:00:00	\N	\N
5257	26	REDENÇÃO DA SERRA	2010-03-11 00:00:00	\N	\N
5258	26	REGENTE FEIJÓ	2010-03-11 00:00:00	\N	\N
5259	26	REGINÓPOLIS	2010-03-11 00:00:00	\N	\N
5260	26	REGISTRO	2010-03-11 00:00:00	\N	\N
5261	26	RESTINGA	2010-03-11 00:00:00	\N	\N
5262	26	RIBEIRA	2010-03-11 00:00:00	\N	\N
5263	26	RIBEIRÃO BONITO	2010-03-11 00:00:00	\N	\N
5264	26	RIBEIRÃO BRANCO	2010-03-11 00:00:00	\N	\N
5265	26	RIBEIRÃO CORRENTE	2010-03-11 00:00:00	\N	\N
5266	26	RIBEIRÃO DO SUL	2010-03-11 00:00:00	\N	\N
5267	26	RIBEIRÃO DOS ÍNDIOS	2010-03-11 00:00:00	\N	\N
5268	26	RIBEIRÃO GRANDE	2010-03-11 00:00:00	\N	\N
5269	26	RIBEIRÃO PIRES	2010-03-11 00:00:00	\N	\N
5270	26	RIBEIRÃO PRETO	2010-03-11 00:00:00	\N	\N
5271	26	RIFAINA	2010-03-11 00:00:00	\N	\N
5272	26	RINCÃO	2010-03-11 00:00:00	\N	\N
5273	26	RINÓPOLIS	2010-03-11 00:00:00	\N	\N
5274	26	RIO CLARO	2010-03-11 00:00:00	\N	\N
5275	26	RIO DAS PEDRAS	2010-03-11 00:00:00	\N	\N
5276	26	RIO GRANDE DA SERRA	2010-03-11 00:00:00	\N	\N
5277	26	RIOLÂNDIA	2010-03-11 00:00:00	\N	\N
5278	26	RIVERSUL	2010-03-11 00:00:00	\N	\N
5279	26	ROSANA	2010-03-11 00:00:00	\N	\N
5280	26	ROSEIRA	2010-03-11 00:00:00	\N	\N
5281	26	RUBIÁCEA	2010-03-11 00:00:00	\N	\N
5282	26	RUBINÉIA	2010-03-11 00:00:00	\N	\N
5283	26	SABINO	2010-03-11 00:00:00	\N	\N
5284	26	SAGRES	2010-03-11 00:00:00	\N	\N
5285	26	SALES	2010-03-11 00:00:00	\N	\N
5286	26	SALES OLIVEIRA	2010-03-11 00:00:00	\N	\N
5287	26	SALESÓPOLIS	2010-03-11 00:00:00	\N	\N
5288	26	SALMOURÃO	2010-03-11 00:00:00	\N	\N
5289	26	SALTINHO	2010-03-11 00:00:00	\N	\N
5290	26	SALTO	2010-03-11 00:00:00	\N	\N
5291	26	SALTO DE PIRAPORA	2010-03-11 00:00:00	\N	\N
5292	26	SALTO GRANDE	2010-03-11 00:00:00	\N	\N
5293	26	SANDOVALINA	2010-03-11 00:00:00	\N	\N
5294	26	SANTA ADÉLIA	2010-03-11 00:00:00	\N	\N
5295	26	SANTA ALBERTINA	2010-03-11 00:00:00	\N	\N
5296	26	SANTA BÁRBARA D OESTE	2010-03-11 00:00:00	\N	\N
5297	26	SANTA BRANCA	2010-03-11 00:00:00	\N	\N
5298	26	SANTA CLARA D OESTE	2010-03-11 00:00:00	\N	\N
5299	26	SANTA CRUZ DA CONCEIÇÃO	2010-03-11 00:00:00	\N	\N
5300	26	SANTA CRUZ DA ESPERANÇA	2010-03-11 00:00:00	\N	\N
5301	26	SANTA CRUZ DAS PALMEIRAS	2010-03-11 00:00:00	\N	\N
5302	26	SANTA CRUZ DO RIO PARDO	2010-03-11 00:00:00	\N	\N
5303	26	SANTA ERNESTINA	2010-03-11 00:00:00	\N	\N
5304	26	SANTA FÉ DO SUL	2010-03-11 00:00:00	\N	\N
5305	26	SANTA GERTRUDES	2010-03-11 00:00:00	\N	\N
5306	26	SANTA ISABEL	2010-03-11 00:00:00	\N	\N
5307	26	SANTA LÚCIA	2010-03-11 00:00:00	\N	\N
5308	26	SANTA MARIA DA SERRA	2010-03-11 00:00:00	\N	\N
5309	26	SANTA MERCEDES	2010-03-11 00:00:00	\N	\N
5310	26	SANTA RITA D OESTE	2010-03-11 00:00:00	\N	\N
5311	26	SANTA RITA DO PASSA QUATRO	2010-03-11 00:00:00	\N	\N
5312	26	SANTA ROSA DE VITERBO	2010-03-11 00:00:00	\N	\N
5313	26	SANTA SALETE	2010-03-11 00:00:00	\N	\N
5314	26	SANTANA DA PONTE PENSA	2010-03-11 00:00:00	\N	\N
5315	26	SANTANA DE PARNAÍBA	2010-03-11 00:00:00	\N	\N
5316	26	SANTO ANASTÁCIO	2010-03-11 00:00:00	\N	\N
5317	26	SANTO ANDRÉ	2010-03-11 00:00:00	\N	\N
5318	26	SANTO ANTÔNIO DA ALEGRIA	2010-03-11 00:00:00	\N	\N
5319	26	SANTO ANTÔNIO DE POSSE	2010-03-11 00:00:00	\N	\N
5320	26	SANTO ANTÔNIO DO ARACANGUÁ	2010-03-11 00:00:00	\N	\N
5321	26	SANTO ANTÔNIO DO JARDIM	2010-03-11 00:00:00	\N	\N
5322	26	SANTO ANTÔNIO DO PINHAL	2010-03-11 00:00:00	\N	\N
5323	26	SANTO EXPEDITO	2010-03-11 00:00:00	\N	\N
5324	26	SANTÓPOLIS DO AGUAPEÍ	2010-03-11 00:00:00	\N	\N
5325	26	SANTOS	2010-03-11 00:00:00	\N	\N
5326	26	SÃO BENTO DO SAPUCAÍ	2010-03-11 00:00:00	\N	\N
5327	26	SÃO BERNARDO DO CAMPO	2010-03-11 00:00:00	\N	\N
5328	26	SÃO CAETANO DO SUL	2010-03-11 00:00:00	\N	\N
5329	26	SÃO CARLOS	2010-03-11 00:00:00	\N	\N
5330	26	SÃO FRANCISCO	2010-03-11 00:00:00	\N	\N
5331	26	SÃO JOÃO DA BOA VISTA	2010-03-11 00:00:00	\N	\N
5332	26	SÃO JOÃO DAS DUAS PONTES	2010-03-11 00:00:00	\N	\N
5333	26	SÃO JOÃO DE IRACEMA	2010-03-11 00:00:00	\N	\N
5334	26	SÃO JOÃO DO PAU D ALHO	2010-03-11 00:00:00	\N	\N
5335	26	SÃO JOAQUIM DA BARRA	2010-03-11 00:00:00	\N	\N
5336	26	SÃO JOSÉ DA BELA VISTA	2010-03-11 00:00:00	\N	\N
5337	26	SÃO JOSÉ DO BARREIRO	2010-03-11 00:00:00	\N	\N
5338	26	SÃO JOSÉ DO RIO PARDO	2010-03-11 00:00:00	\N	\N
5339	26	SÃO JOSÉ DO RIO PRETO	2010-03-11 00:00:00	\N	\N
5340	26	SÃO JOSÉ DOS CAMPOS	2010-03-11 00:00:00	\N	\N
5341	26	SÃO LOURENÇO DA SERRA	2010-03-11 00:00:00	\N	\N
5342	26	SÃO LUÍS DO PARAITINGA	2010-03-11 00:00:00	\N	\N
5343	26	SÃO MANUEL	2010-03-11 00:00:00	\N	\N
5344	26	SÃO MIGUEL ARCANJO	2010-03-11 00:00:00	\N	\N
5345	26	SÃO PAULO	2010-03-11 00:00:00	\N	\N
5346	26	SÃO PEDRO	2010-03-11 00:00:00	\N	\N
5347	26	SÃO PEDRO DO TURVO	2010-03-11 00:00:00	\N	\N
5348	26	SÃO ROQUE	2010-03-11 00:00:00	\N	\N
5349	26	SÃO SEBASTIÃO	2010-03-11 00:00:00	\N	\N
5350	26	SÃO SEBASTIÃO DA GRAMA	2010-03-11 00:00:00	\N	\N
5351	26	SÃO SIMÃO	2010-03-11 00:00:00	\N	\N
5352	26	SÃO VICENTE	2010-03-11 00:00:00	\N	\N
5353	26	SARAPUÍ	2010-03-11 00:00:00	\N	\N
5354	26	SARUTAIA	2010-03-11 00:00:00	\N	\N
5355	26	SEBASTIANÓPOLIS DO SUL	2010-03-11 00:00:00	\N	\N
5356	26	SERRA AZUL	2010-03-11 00:00:00	\N	\N
5357	26	SERRA NEGRA	2010-03-11 00:00:00	\N	\N
5358	26	SERRANA	2010-03-11 00:00:00	\N	\N
5359	26	SERTÃOZINHO	2010-03-11 00:00:00	\N	\N
5360	26	SETE BARRAS	2010-03-11 00:00:00	\N	\N
5361	26	SEVERÍNIA	2010-03-11 00:00:00	\N	\N
5362	26	SILVEIRAS	2010-03-11 00:00:00	\N	\N
5363	26	SOCORRO	2010-03-11 00:00:00	\N	\N
5364	26	SOROCABA	2010-03-11 00:00:00	\N	\N
5365	26	SUD MENNUCCI	2010-03-11 00:00:00	\N	\N
5366	26	SUMARÉ	2010-03-11 00:00:00	\N	\N
5367	26	SUZANÁPOLIS	2010-03-11 00:00:00	\N	\N
5368	26	SUZANO	2010-03-11 00:00:00	\N	\N
5369	26	TABAPUÃ	2010-03-11 00:00:00	\N	\N
5370	26	TABATINGA	2010-03-11 00:00:00	\N	\N
5371	26	TABOÃO DA SERRA	2010-03-11 00:00:00	\N	\N
5372	26	TACIBA	2010-03-11 00:00:00	\N	\N
5373	26	TAGUAÍ	2010-03-11 00:00:00	\N	\N
5374	26	TAIAÇU	2010-03-11 00:00:00	\N	\N
5375	26	TAIÚVA	2010-03-11 00:00:00	\N	\N
5376	26	TAMBAÚ	2010-03-11 00:00:00	\N	\N
5377	26	TANABI	2010-03-11 00:00:00	\N	\N
5378	26	TAPIRAÍ	2010-03-11 00:00:00	\N	\N
5379	26	TAPIRATIBA	2010-03-11 00:00:00	\N	\N
5380	26	TAQUARAL	2010-03-11 00:00:00	\N	\N
5381	26	TAQUARITINGA	2010-03-11 00:00:00	\N	\N
5382	26	TAQUARITUBA	2010-03-11 00:00:00	\N	\N
5383	26	TAQUARIVAÍ	2010-03-11 00:00:00	\N	\N
5384	26	TARABAÍ	2010-03-11 00:00:00	\N	\N
5385	26	TARUMÃ	2010-03-11 00:00:00	\N	\N
5386	26	TATUÍ	2010-03-11 00:00:00	\N	\N
5387	26	TAUBATÉ	2010-03-11 00:00:00	\N	\N
5388	26	TEJUPA	2010-03-11 00:00:00	\N	\N
5389	26	TEODORO SAMPAIO	2010-03-11 00:00:00	\N	\N
5390	26	TERRA ROXA	2010-03-11 00:00:00	\N	\N
5391	26	TIETÊ	2010-03-11 00:00:00	\N	\N
5392	26	TIMBURI	2010-03-11 00:00:00	\N	\N
5393	26	TORRE DE PEDRA	2010-03-11 00:00:00	\N	\N
5394	26	TORRINHA	2010-03-11 00:00:00	\N	\N
5395	26	TRABIJU	2010-03-11 00:00:00	\N	\N
5396	26	TREMEMBÉ	2010-03-11 00:00:00	\N	\N
5397	26	TRÊS FRONTEIRAS	2010-03-11 00:00:00	\N	\N
5398	26	TUIUTI	2010-03-11 00:00:00	\N	\N
5399	26	TUPÃ	2010-03-11 00:00:00	\N	\N
5400	26	TUPI PAULISTA	2010-03-11 00:00:00	\N	\N
5401	26	TURIÚBA	2010-03-11 00:00:00	\N	\N
5402	26	TURMALINA	2010-03-11 00:00:00	\N	\N
5403	26	UBARANA	2010-03-11 00:00:00	\N	\N
5404	26	UBATUBA	2010-03-11 00:00:00	\N	\N
5405	26	UBIRAJARA	2010-03-11 00:00:00	\N	\N
5406	26	UCHOA	2010-03-11 00:00:00	\N	\N
5407	26	UNIÃO PAULISTA	2010-03-11 00:00:00	\N	\N
5408	26	URÂNIA	2010-03-11 00:00:00	\N	\N
5409	26	URU	2010-03-11 00:00:00	\N	\N
5410	26	URUPÊS	2010-03-11 00:00:00	\N	\N
5411	26	VALENTIM GENTIL	2010-03-11 00:00:00	\N	\N
5412	26	VALINHOS	2010-03-11 00:00:00	\N	\N
5413	26	VALPARAÍSO	2010-03-11 00:00:00	\N	\N
5414	26	VARGEM	2010-03-11 00:00:00	\N	\N
5415	26	VARGEM GRANDE DO SUL	2010-03-11 00:00:00	\N	\N
5416	26	VARGEM GRANDE PAULISTA	2010-03-11 00:00:00	\N	\N
5417	26	VÁRZEA PAULISTA	2010-03-11 00:00:00	\N	\N
5418	26	VERA CRUZ	2010-03-11 00:00:00	\N	\N
5419	26	VINHEDO	2010-03-11 00:00:00	\N	\N
5420	26	VIRADOURO	2010-03-11 00:00:00	\N	\N
5421	26	VISTA ALEGRE DO ALTO	2010-03-11 00:00:00	\N	\N
5422	26	VITÓRIA BRASIL	2010-03-11 00:00:00	\N	\N
5423	26	VOTORANTIM	2010-03-11 00:00:00	\N	\N
5424	26	VOTUPORANGA	2010-03-11 00:00:00	\N	\N
5425	26	ZACARIAS	2010-03-11 00:00:00	\N	\N
5426	27	ABREULÂNDIA	2010-03-11 00:00:00	\N	\N
5427	27	AGUIARNÓPOLIS	2010-03-11 00:00:00	\N	\N
5428	27	ALIANÇA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5429	27	ALMAS	2010-03-11 00:00:00	\N	\N
5430	27	ALVORADA	2010-03-11 00:00:00	\N	\N
5431	27	ANANAS	2010-03-11 00:00:00	\N	\N
5432	27	ANGICO	2010-03-11 00:00:00	\N	\N
5433	27	APARECIDA DO RIO NEGRO	2010-03-11 00:00:00	\N	\N
5434	27	ARAGOMINAS	2010-03-11 00:00:00	\N	\N
5435	27	ARAGUACEMA	2010-03-11 00:00:00	\N	\N
5436	27	ARAGUAÇU	2010-03-11 00:00:00	\N	\N
5437	27	ARAGUAÍNA	2010-03-11 00:00:00	\N	\N
5438	27	ARAGUANÃ	2010-03-11 00:00:00	\N	\N
5439	27	ARAGUATINS	2010-03-11 00:00:00	\N	\N
5440	27	ARAPOEMA	2010-03-11 00:00:00	\N	\N
5441	27	ARRAIAS	2010-03-11 00:00:00	\N	\N
5442	27	AUGUSTINÓPOLIS	2010-03-11 00:00:00	\N	\N
5443	27	AURORA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5444	27	AXIXÁ DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5445	27	BABAÇULÂNDIA	2010-03-11 00:00:00	\N	\N
5446	27	BANDEIRANTES DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5447	27	BARRA DO OURO	2010-03-11 00:00:00	\N	\N
5448	27	BARROLÂNDIA	2010-03-11 00:00:00	\N	\N
5449	27	BERNARDO SAYÃO	2010-03-11 00:00:00	\N	\N
5450	27	BOM JESUS DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5451	27	BRASILÂNDIA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5452	27	BREJINHO DE NAZARÉ	2010-03-11 00:00:00	\N	\N
5453	27	BURITI DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5454	27	CACHOEIRINHA	2010-03-11 00:00:00	\N	\N
5455	27	CAMPOS LINDOS	2010-03-11 00:00:00	\N	\N
5456	27	CARIRI DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5457	27	CARMOLÂNDIA	2010-03-11 00:00:00	\N	\N
5458	27	CARRASCO BONITO	2010-03-11 00:00:00	\N	\N
5459	27	CASEARA	2010-03-11 00:00:00	\N	\N
5460	27	CENTENÁRIO	2010-03-11 00:00:00	\N	\N
5461	27	CHAPADA DA NATIVIDADE	2010-03-11 00:00:00	\N	\N
5462	27	CHAPADA DE AREIA	2010-03-11 00:00:00	\N	\N
5463	27	COLINAS DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5464	27	COLMÉIA	2010-03-11 00:00:00	\N	\N
5465	27	COMBINADO	2010-03-11 00:00:00	\N	\N
5466	27	CONCEIÇÃO DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5467	27	COUTO DE MAGALHÃES	2010-03-11 00:00:00	\N	\N
5468	27	CRISTALÂNDIA	2010-03-11 00:00:00	\N	\N
5469	27	CRIXAS DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5470	27	DARCINÓPOLIS	2010-03-11 00:00:00	\N	\N
5471	27	DIANÓPOLIS	2010-03-11 00:00:00	\N	\N
5472	27	DIVINÓPOLIS DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5473	27	DOIS IRMÃOS DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5474	27	DUERE	2010-03-11 00:00:00	\N	\N
5475	27	ESPERANTINA	2010-03-11 00:00:00	\N	\N
5476	27	FÁTIMA	2010-03-11 00:00:00	\N	\N
5477	27	FIGUEIRÓPOLIS	2010-03-11 00:00:00	\N	\N
5478	27	FILADÉLFIA	2010-03-11 00:00:00	\N	\N
5479	27	FORMOSO DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
5480	27	FORTALEZA DO TABOCÃO	2010-03-11 00:00:00	\N	\N
5481	27	GOIANORTE	2010-03-11 00:00:00	\N	\N
5482	27	GOIATINS	2010-03-11 00:00:00	\N	\N
5483	27	GUARAÍ	2010-03-11 00:00:00	\N	\N
5484	27	GURUPI	2010-03-11 00:00:00	\N	\N
5485	27	IPUEIRAS	2010-03-11 00:00:00	\N	\N
5486	27	ITACAJÁ	2010-03-11 00:00:00	\N	\N
5487	27	ITAGUATINS	2010-03-11 00:00:00	\N	\N
5488	27	ITAPIRATINS	2010-03-11 00:00:00	\N	\N
5489	27	ITAPORÃ DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5490	27	JAÚ DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5491	27	JUARINA	2010-03-11 00:00:00	\N	\N
5492	27	LAGOA DA CONFUSÃO	2010-03-11 00:00:00	\N	\N
5493	27	LAGOA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5494	27	LAJEADO	2010-03-11 00:00:00	\N	\N
5495	27	LAVANDEIRA	2010-03-11 00:00:00	\N	\N
5496	27	LIZARDA	2010-03-11 00:00:00	\N	\N
5497	27	LUZINÓPOLIS	2010-03-11 00:00:00	\N	\N
5498	27	MARIANÓPOLIS DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5499	27	MATEIROS	2010-03-11 00:00:00	\N	\N
5500	27	MAURILÂNDIA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5501	27	MIRACEMA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5502	27	MIRANORTE	2010-03-11 00:00:00	\N	\N
5503	27	MONTE DO CARMO	2010-03-11 00:00:00	\N	\N
5504	27	MONTE SANTO DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5505	27	MURICILÂNDIA	2010-03-11 00:00:00	\N	\N
5506	27	NATIVIDADE	2010-03-11 00:00:00	\N	\N
5507	27	NAZARÉ	2010-03-11 00:00:00	\N	\N
5508	27	NOVA OLINDA	2010-03-11 00:00:00	\N	\N
5509	27	NOVA ROSALÂNDIA	2010-03-11 00:00:00	\N	\N
5510	27	NOVO ACORDO	2010-03-11 00:00:00	\N	\N
5511	27	NOVO ALEGRE	2010-03-11 00:00:00	\N	\N
5512	27	NOVO JARDIM	2010-03-11 00:00:00	\N	\N
5513	27	OLIVEIRA DE FÁTIMA	2010-03-11 00:00:00	\N	\N
5514	27	PALMAS	2010-03-11 00:00:00	\N	\N
5515	27	PALMEIRANTE	2010-03-11 00:00:00	\N	\N
5516	27	PALMEIRAS DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5517	27	PALMEIRÓPOLIS	2010-03-11 00:00:00	\N	\N
5518	27	PARAÍSO DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5519	27	PARANÃ	2010-03-11 00:00:00	\N	\N
5520	27	PAU D ARCO	2010-03-11 00:00:00	\N	\N
5521	27	PEDRO AFONSO	2010-03-11 00:00:00	\N	\N
5522	27	PEIXE	2010-03-11 00:00:00	\N	\N
5523	27	PEQUIZEIRO	2010-03-11 00:00:00	\N	\N
5524	27	PINDORAMA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5525	27	PIRAQUÊ	2010-03-11 00:00:00	\N	\N
5526	27	PIUM	2010-03-11 00:00:00	\N	\N
5527	27	PONTE ALTA DO BOM JESUS	2010-03-11 00:00:00	\N	\N
5528	27	PONTE ALTA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5529	27	PORTO ALEGRE DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5530	27	PORTO NACIONAL	2010-03-11 00:00:00	\N	\N
5531	27	PRAIA NORTE	2010-03-11 00:00:00	\N	\N
5532	27	PRESIDENTE KENNEDY	2010-03-11 00:00:00	\N	\N
5533	27	PUGMIL	2010-03-11 00:00:00	\N	\N
5534	27	RECURSOLÂNDIA	2010-03-11 00:00:00	\N	\N
5535	27	RIACHINHO	2010-03-11 00:00:00	\N	\N
5536	27	RIO DA CONCEIÇÃO	2010-03-11 00:00:00	\N	\N
5537	27	RIO DOS BOIS	2010-03-11 00:00:00	\N	\N
5538	27	RIO SONO	2010-03-11 00:00:00	\N	\N
5539	27	SAMPAIO	2010-03-11 00:00:00	\N	\N
5540	27	SANDOLÂNDIA	2010-03-11 00:00:00	\N	\N
5541	27	SANTA FÉ DO ARAGUAIA	2010-03-11 00:00:00	\N	\N
5542	27	SANTA MARIA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5543	27	SANTA RITA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5544	27	SANTA ROSA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5545	27	SANTA TEREZA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5546	27	SANTA TEREZINHA DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5547	27	SÃO BENTO DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5548	27	SÃO FÉLIX DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5549	27	SÃO MIGUEL DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5550	27	SÃO SALVADOR DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5551	27	SÃO SEBASTIÃO DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5552	27	SÃO VALÉRIO DA NATIVIDADE	2010-03-11 00:00:00	\N	\N
5553	27	SILVANÓPOLIS	2010-03-11 00:00:00	\N	\N
5554	27	SÍTIO NOVO DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5555	27	SUCUPIRA	2010-03-11 00:00:00	\N	\N
5556	27	TAGUATINGA	2010-03-11 00:00:00	\N	\N
5557	27	TAIPAS DO TOCANTINS	2010-03-11 00:00:00	\N	\N
5558	27	TALISMÃ	2010-03-11 00:00:00	\N	\N
5559	27	TOCANTÍNIA	2010-03-11 00:00:00	\N	\N
5560	27	TOCANTINÓPOLIS	2010-03-11 00:00:00	\N	\N
5561	27	TUPIRAMA	2010-03-11 00:00:00	\N	\N
5562	27	TUPIRATINS	2010-03-11 00:00:00	\N	\N
5563	27	WANDERLÂNDIA	2010-03-11 00:00:00	\N	\N
5564	27	XAMBIOÁ	2010-03-11 00:00:00	\N	\N
1346	11	ABADIA DOS DOURADOS	2010-03-11 00:00:00	\N	\N
2418	14	ABAETETUBA	2010-03-11 00:00:00	\N	\N
5565	12	maria paula	2012-06-07 13:08:22.146	\N	\N
4227	23	PELOTAS	2010-03-11 00:00:00	-31.776045078330885	-52.359466552734375
538	5	SALVADOR	2010-03-11 00:00:00	-12.897489183756134	-38.671875
\.


--
-- Name: cidades_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('cidades_id_seq', 5565, true);


--
-- Data for Name: empresas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY empresas (id, nome, cnpj, dt_cadastro) FROM stdin;
1	Área Administrativa	\N	2010-01-07
3	Plataforma do Paraformal	\N	2012-05-05
\.


--
-- Name: empresas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('empresas_id_seq', 3, true);


--
-- Data for Name: empresas_perfis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY empresas_perfis (empresa_id, perfil_id) FROM stdin;
1	1
3	3
3	4
3	5
\.


--
-- Data for Name: enderecos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY enderecos (id, pessoa_id, endereco_tipo_id, cidade_id, cep, rua, numero, bairro, complemento, dt_cadastro) FROM stdin;
\.


--
-- Name: enderecos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('enderecos_id_seq', 1, false);


--
-- Data for Name: enderecos_tipos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY enderecos_tipos (id, descricao, flg_tipo, dt_cadastro) FROM stdin;
\.


--
-- Name: enderecos_tipos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('enderecos_tipos_id_seq', 1, false);


--
-- Data for Name: estados_civis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY estados_civis (id, descricao) FROM stdin;
8	SOLTEIRO
9	CASADO
10	VIUVO
11	DIVORCIADO
12	DESQUITADO
13	OUTROS
\.


--
-- Name: estados_civis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('estados_civis_id_seq', 13, true);


--
-- Name: geocode_cache_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('geocode_cache_seq', 1, false);


--
-- Name: geocode_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('geocode_id_seq', 2, true);


--
-- Data for Name: grupos_acessos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grupos_acessos (id, nome, dt_cadastro) FROM stdin;
1	ADMINISTRADOR	2012-04-26 00:00:00
2	EQUIPE	2012-05-19 12:39:47.723854
\.


--
-- Data for Name: grupos_acessos_empresas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grupos_acessos_empresas (id, grupo_acesso_id, empresa_id) FROM stdin;
1	1	1
2	1	3
3	2	3
\.


--
-- Name: grupos_acessos_empresas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grupos_acessos_empresas_id_seq', 3, true);


--
-- Name: grupos_acessos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grupos_acessos_id_seq', 2, true);


--
-- Data for Name: grupos_acessos_perfis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grupos_acessos_perfis (id, grupo_acesso_id, empresa_id, perfil_id) FROM stdin;
1	1	1	1
4	1	3	3
5	1	3	4
6	1	3	5
7	2	3	3
8	2	3	4
9	2	3	5
\.


--
-- Name: grupos_acessos_perfis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grupos_acessos_perfis_id_seq', 9, true);


--
-- Data for Name: grupos_acessos_programas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grupos_acessos_programas (id, grupo_acesso_id, empresa_id, perfil_id, programa_id, dt_cadastro) FROM stdin;
40	2	3	4	18	2013-02-17 13:22:32.663387
41	2	3	4	19	2013-02-17 13:22:32.663387
50	1	1	1	8	2013-02-17 13:24:28.788576
51	1	1	1	9	2013-02-17 13:24:28.788576
52	1	1	1	3	2013-02-17 13:24:28.788576
53	1	1	1	10	2013-02-17 13:24:28.788576
54	1	1	1	12	2013-02-17 13:24:28.788576
55	1	1	1	1	2013-02-17 13:24:28.788576
56	1	1	1	5	2013-02-17 13:24:28.788576
57	1	1	1	4	2013-02-17 13:24:28.788576
58	1	1	1	2	2013-02-17 13:24:28.788576
\.


--
-- Name: grupos_acessos_programas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grupos_acessos_programas_id_seq', 58, true);


--
-- Data for Name: grupos_acessos_programas_permissoes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grupos_acessos_programas_permissoes (id, grupo_acesso_id, sys_metodo_id, dt_cadastro) FROM stdin;
1	1	34	2012-04-26 00:00:00
2	1	36	2012-04-26 00:00:00
3	1	38	2012-04-26 00:00:00
4	1	35	2012-04-26 00:00:00
5	1	39	2012-04-26 00:00:00
6	1	44	2012-04-26 00:00:00
\.


--
-- Name: grupos_acessos_programas_permissoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grupos_acessos_programas_permissoes_id_seq', 6, true);


--
-- Data for Name: log_fields; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY log_fields (id, log_table_id, field_name, old_value, new_value) FROM stdin;
\.


--
-- Name: log_fields_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('log_fields_id_seq', 1, false);


--
-- Data for Name: log_fields_structures; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY log_fields_structures (id, log_table_structure_id, field_name) FROM stdin;
\.


--
-- Name: log_fields_structures_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('log_fields_structures_id_seq', 1, false);


--
-- Data for Name: log_tables; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY log_tables (id, table_name, table_id, flg_action, dt_register) FROM stdin;
\.


--
-- Name: log_tables_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('log_tables_id_seq', 1, false);


--
-- Data for Name: log_tables_structures; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY log_tables_structures (id, table_name) FROM stdin;
\.


--
-- Name: log_tables_structures_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('log_tables_structures_id_seq', 1, false);


--
-- Data for Name: parametros; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY parametros (id, nome, descricao, valor, dt_cadastro) FROM stdin;
1	PESSOA_TIPO_COLABORADOR	id da tabela pessoas_tipos relativo a colaboradores	1	2012-05-05
\.


--
-- Name: parametros_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('parametros_id_seq', 1, true);


--
-- Data for Name: perfis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY perfis (id, nome_perfil, flg_ativo, dt_cadastro) FROM stdin;
2	Início	S	2010-01-07
3	Cadastros Básicos	S	2012-05-05
4	Equipe	S	2012-05-19
5	Cadastros	S	2012-05-29
1	Administrador do Sistema	S	2010-01-07
\.


--
-- Name: perfis_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('perfis_id_seq', 5, true);


--
-- Data for Name: perfis_programas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY perfis_programas (id, perfil_id, programa_id, programa_pai, ordem, flg_ativo) FROM stdin;
16	1	9	8	1	S
17	1	3	8	2	S
13	1	5	1	0	S
15	1	4	1	1	S
14	1	2	1	2	S
18	1	8	0	0	S
19	1	1	0	1	S
240	1	10	8	4	S
242	1	12	8	5	S
249	4	18	0	1	S
250	4	19	0	2	S
252	5	21	0	1	S
253	5	22	0	2	S
247	3	17	0	5	S
254	3	23	0	6	S
255	3	24	0	7	S
256	3	14	0	8	S
257	3	25	0	9	S
258	3	26	0	10	S
259	3	27	0	11	S
260	3	28	0	12	S
261	3	29	0	13	S
262	3	30	0	14	S
263	5	31	0	3	S
264	5	32	0	4	S
265	1	33	1	3	S
\.


--
-- Name: perfis_programas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('perfis_programas_id_seq', 265, true);


--
-- Data for Name: pessoas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY pessoas (id, nome, cpf, rg, estado_civil_id, sexo, dt_nascimento, nome_pai, nome_mae, telefone, celular, email, observacao, dt_cadastro, orgao_emissor_rg, orgao_emissor_rg_unidade_federativa_id, flg_mao_escrita, nacionalidade, dt_atualizacao_gol, nr_titulo_eleitor, hash_ativacao, email_ativacao, senha_ativacao, foto_carteira_id, cod_carteira, pessoa_tipo_id, nome_consulta, cidade_id, profissao) FROM stdin;
1	Administrador do Sistema	12345678910	\N	\N	M	\N	\N	\N	\N	\N	administrador@localhost	\N	2010-02-18 22:00:01	\N	\N	D	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N	\N
5	USUÁRIO DE TESTE			\N	M	2101-01-01	\N	\N	\N	\N	usuario@uol.com	\N	2012-05-12 19:15:35.052181	\N	\N	D	\N	\N	\N	\N	\N	\N	\N	\N	\N	USUARIO DE TESTE	\N	\N
\.


--
-- Name: pessoas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('pessoas_id_seq', 7, true);


--
-- Data for Name: pessoas_tipos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY pessoas_tipos (id, tipo, dt_cadastro) FROM stdin;
1	Colaborador	2012-05-05 22:51:38.600373
2	Integrante	2012-06-09 17:48:37.038521
\.


--
-- Name: pessoas_tipos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('pessoas_tipos_id_seq', 2, true);


--
-- Data for Name: programas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY programas (id, nome_programa, descricao, link, onclick, dt_cadastro) FROM stdin;
1	Gerenciador				2008-04-02
4	Parâmetros		gerenciador/parametro		2008-04-02
2	Programas		gerenciador/programa		2008-04-02
8	Usuários e módulos				2008-04-09
3	Módulos		gerenciador/perfil		2008-04-02
5	Setores		gerenciador/empresa		2008-04-05
9	Usuários		gerenciador/usuario		2008-04-09
10	Grupos de Acesso	Montar os itens de menu que o grupo poderá visualizar	gerenciador/grupoAcesso		2012-04-26
12	Tipo Pessoas	Tipo de pessoas	gerenciador/pessoaTipo		2012-05-05
18	Registros de Atividades		paraformalidade/equipe/registroAtividade		2012-05-19
19	Ver Registros de Atividades		paraformalidade/equipe/verRegistroAtividade		2012-05-19
21	Paraformalidades		paraformalidade/cadastros/paraformalidade		2012-05-29
14	Corpo Posições		paraformalidade/cadastrosBasicos/corpoPosicoes		2012-05-13
17	Atividades Registradas		paraformalidade/cadastrosBasicos/atividadesRegistrada		2012-05-17
24	Corpo Numeros		paraformalidade/cadastrosBasicos/corpoNumeros		2013-02-17
25	Equipamento Instalações		paraformalidade/cadastrosBasicos/equipamentoInstalacoes		2013-02-17
26	Equipamento Mobilidades		paraformalidade/cadastrosBasicos/equipamentoMobilidades		2013-02-17
27	Equipamento Portes		paraformalidade/cadastrosBasicos/equipamentoPortes		2013-02-17
28	Espaço Localizações		paraformalidade/cadastrosBasicos/espacoLocalizacoes		2013-02-17
29	Quantidades Registradas		paraformalidade/cadastrosBasicos/quantidadesRegistrada		2013-02-17
30	Turnos Ocorrência		paraformalidade/cadastrosBasicos/turnosOcorrencia		2013-02-17
22	Grupos de Atividade		paraformalidade/cadastros/gruposAtividades		2012-06-05
23	Condicionantes Ambiental		paraformalidade/cadastrosBasicos/condicionantesAmbiental		2013-02-17
31	Colaboradores		paraformalidade/cadastros/colaboradores		2013-02-24
32	Grupos de Atividades (Equipe)		paraformalidade/cadastros/equipesGruposAtividades		2013-03-26
33	Cidades	Cidades	gerenciador/cidade/		2013-04-01
\.


--
-- Name: programas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('programas_id_seq', 33, true);


--
-- Data for Name: programas_parametros; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY programas_parametros (id, programa_id, nome, dt_cadastro) FROM stdin;
\.


--
-- Name: programas_parametros_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('programas_parametros_id_seq', 1, false);


--
-- Data for Name: sys_metodos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY sys_metodos (id, classe, metodo, apelido, privado, dt_cadastro) FROM stdin;
34	gerenciador/usuario	novo	gerenciador/usuario/novo	1	2011-01-25 00:00:00
36	gerenciador/usuario	salvar	gerenciador/usuario/salvar	1	2011-01-25 00:00:00
37	academico/cadastros/curso	novo	academico/cadastros/curso/novo	1	2011-01-25 00:00:00
38	gerenciador/usuario	incluirEmpresa	gerenciador/usuario/incluirEmpresa	1	2011-01-25 00:00:00
35	gerenciador/usuario	editar	gerenciador/usuario/editar	0	2011-01-25 00:00:00
39	gerenciador/usuario	salvarUsuarioProgramaAcessos	gerenciador/usuario/salvarUsuarioProgramaAcessos	1	2011-01-27 00:00:00
40	academico/cadastros/disciplina	novo	academico/cadastros/disciplina/novo	1	2011-01-27 00:00:00
41	academico/cadastros/disciplina	salvar	academico/cadastros/disciplina/salvar	1	2011-01-27 00:00:00
42	academico/cadastros/disciplina	excluir	academico/cadastros/disciplina/excluir	1	2011-01-27 00:00:00
43	academico/cadastros/disciplina	editar	academico/cadastros/disciplina/editar	1	2011-02-16 00:00:00
44	gerenciador/usuario	fazerLoginComo	gerenciador/usuario/fazerLoginComo	1	2011-09-12 00:00:00
\.


--
-- Name: sys_metodos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('sys_metodos_id_seq', 44, true);


--
-- Data for Name: sys_permissoes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY sys_permissoes (id, sys_metodo_id, usuario_id, dt_cadastro) FROM stdin;
82	35	1	2011-11-15 00:00:00
83	44	1	2011-11-15 00:00:00
84	38	1	2011-11-15 00:00:00
85	34	1	2011-11-15 00:00:00
86	36	1	2011-11-15 00:00:00
87	39	1	2011-11-15 00:00:00
\.


--
-- Name: sys_permissoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('sys_permissoes_id_seq', 87, true);


--
-- Data for Name: telefones; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY telefones (id, pessoa_id, telefone_tipo_id, numero, dt_cadastro) FROM stdin;
\.


--
-- Name: telefones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('telefones_id_seq', 1, false);


--
-- Data for Name: telefones_tipos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY telefones_tipos (id, descricao, flg_tipo, dt_cadastro) FROM stdin;
\.


--
-- Name: telefones_tipos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('telefones_tipos_id_seq', 1, false);


--
-- Data for Name: tipo_enderecos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tipo_enderecos (id, nome) FROM stdin;
\.


--
-- Name: tipo_enderecos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_enderecos_id_seq', 1, false);


--
-- Data for Name: unidades_federativas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY unidades_federativas (id, sigla, nome, dt_cadastro) FROM stdin;
1	AC	Acre	2010-02-25 00:00:00
2	AL	Alagoas	2010-02-25 00:00:00
3	AM	Amazonas	2010-02-25 00:00:00
4	AP	Amapá	2010-02-25 00:00:00
5	BA	Bahia	2010-02-25 00:00:00
6	CE	Ceará	2010-02-25 00:00:00
7	DF	Distrito Federal	2010-02-25 00:00:00
8	ES	Espírito Santo	2010-02-25 00:00:00
9	GO	Goiás	2010-02-25 00:00:00
10	MA	Maranhão	2010-02-25 00:00:00
11	MG	Minas Gerais	2010-02-25 00:00:00
12	MS	Mato Grosso do Sul	2010-02-25 00:00:00
13	MT	Mato Grosso	2010-02-25 00:00:00
14	PA	Pará	2010-02-25 00:00:00
15	PB	Paraíba	2010-02-25 00:00:00
16	PE	Pernambuco	2010-02-25 00:00:00
17	PI	Piauí	2010-02-25 00:00:00
18	PR	Paraná	2010-02-25 00:00:00
19	RJ	Rio de Janeiro	2010-02-25 00:00:00
20	RN	Rio Grande do Norte	2010-02-25 00:00:00
21	RO	Rondônia	2010-02-25 00:00:00
22	RR	Roraima	2010-02-25 00:00:00
23	RS	Rio Grande do Sul	2010-02-25 00:00:00
24	SC	Santa Catarina	2010-02-25 00:00:00
25	SE	Sergipe	2010-02-25 00:00:00
26	SP	São Paulo	2010-02-25 00:00:00
27	TO	Tocantins	2010-02-25 00:00:00
\.


--
-- Name: unidades_federativas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('unidades_federativas_id_seq', 27, true);


--
-- Data for Name: uploads; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY uploads (id, nome_gerado, nome_original, tamanho, tipo, dt_cadastro) FROM stdin;
21	dd8ae2b46a9d8dd5f90e1acae33165da.jpg	fireworks.jpg	39.71	image/jpeg	2013-03-31 14:10:03.337239
22	4543a72cb69edac80dbbc6f598a20adf.jpg	69291_625732320776670_2065593510_n.jpg	22.72	image/jpeg	2013-03-31 14:13:25.948396
23	5b2fdc57cd6db6973e86da85a8a9d9af.png	Enso2.png	34.7	image/png	2013-03-31 14:28:54.577606
24	8a1eeecd163c05118227117d603fc586.png	Enso2.png	34.7	image/png	2013-03-31 14:37:37.436688
25	3f9ddf7326c6c7c17759a0c33a64be97.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-03-31 14:58:52.338594
26	aa08ffcda4bd9beab61c93a90ce483d4.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-03-31 15:00:09.766599
27	3d08e46b4589fa61401bf90bbcb29dc3.jpg	69291_625732320776670_2065593510_n.jpg	22.72	image/jpeg	2013-03-31 15:01:32.285028
28	7fbc99ed48be9da0c615cce7eef1e6c5.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-03-31 15:02:52.178485
29	e47d2ae8562ee5f3ead51749df706f01.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-03-31 15:04:43.140685
30	5ac421192354ed6dfc9732eccb6ae5de.jpg	69291_625732320776670_2065593510_n.jpg	22.72	image/jpeg	2013-03-31 15:06:39.310552
31	5f69fda382ae5791effc2bb679489d0c.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-03-31 15:07:59.696473
32	eae0fe9f3720c277e785d2c2e78b22fe.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-03-31 15:11:13.266519
33	b89a6c065e5dda5f95805d813589458d.JPG	bg-advertising-foot.JPG	46.31	image/jpeg	2013-04-01 08:40:13.801795
34	8b3f1063716d7fcaed6618df56b6d31b.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-04-01 08:49:22.976662
35	d2702c2561951e914d15a669c9fa447d.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-04-01 09:35:38.110997
36	a11f51a86b7d47a84942b73dd986f518.png	Enso2.png	34.7	image/png	2013-04-01 10:02:21.529321
37	b5baa60298f0022c2d6b18274485d929.png	Enso2.png	34.7	image/png	2013-04-01 10:04:56.490206
38	8afa0278191bfb41177262f7418b23b4.jpg	fireworks.jpg	39.71	image/jpeg	2013-04-01 10:07:48.617175
39	fd96cf0e54aec2eb59d50b5271563b54.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-04-01 10:09:58.446649
40	d0a43c3c1989a760df1ca2efd02c1791.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-04-01 10:11:24.619729
41	67ca239ec0aef29fd072403fbac3afb6.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-04-01 10:12:00.717751
42	edcfda1c9ff3b3667d5d8607122123f4.png	Enso2.png	34.7	image/png	2013-04-02 09:54:17.781472
43	59048cc52dd196e56dd824ae26892421.jpg	775001_473096256070846_1701238033_o.jpg	33.73	image/jpeg	2013-04-02 09:57:06.889348
44	738390d64b593c01150ea5ca8409e854.png	Enso2.png	34.7	image/png	2013-04-02 10:38:24.50145
45	4da91adf543b7a44ceb4e4512831a63b.png	Globe.png	4.81	image/png	2013-04-02 11:00:32.255431
46	d6acf9e7881c56038e55e68635f138ca.png	Globe.png	4.81	image/png	2013-04-02 11:01:02.771578
47	c8bf183424a350fd910d41385a3683ea.png	Enso2.png	34.7	image/png	2013-04-02 21:45:56.134251
48	69b1859c8dfde9003f420e1659da090b.png	Enso2.png	34.7	image/png	2013-04-02 21:46:45.266236
49	93b8674f18f7dd723c77ac10c806fe4b.png	Enso2.png	34.7	image/png	2013-04-02 21:48:06.528963
\.


--
-- Name: uploads_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('uploads_id_seq', 49, true);


--
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY usuarios (id, pessoa_id, login, senha, dt_cadastro, hash_id, avatar_id, tema) FROM stdin;
1	1	admin	d033e22ae348aeb5660fc2140aec35850c4da997	2010-02-18 22:00:01	\N	\N	redmond
3	5	usuario	b665e217b51994789b02b1838e730d6b93baa30f	2012-05-12 19:15:35.052181	\N	\N	redmond
\.


--
-- Data for Name: usuarios_empresas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY usuarios_empresas (usuario_id, empresa_id, empresa_boot) FROM stdin;
1	3	S
1	1	N
\.


--
-- Data for Name: usuarios_grupos_acessos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY usuarios_grupos_acessos (id, usuario_id, grupo_acesso_id, dt_cadastro) FROM stdin;
\.


--
-- Name: usuarios_grupos_acessos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('usuarios_grupos_acessos_id_seq', 2, true);


--
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('usuarios_id_seq', 3, true);


--
-- Data for Name: usuarios_perfis; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY usuarios_perfis (empresa_id, usuario_id, perfil_id) FROM stdin;
1	1	2
1	1	1
1	1	4
3	1	3
3	1	4
3	1	5
\.


--
-- Data for Name: usuarios_programas_acessos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY usuarios_programas_acessos (id, usuario_id, empresa_id, perfil_id, programa_id, dt_cadastro) FROM stdin;
11515	1	1	1	8	2013-04-01 17:20:48.166937
11516	1	1	1	9	2013-04-01 17:20:48.166937
11517	1	1	1	3	2013-04-01 17:20:48.166937
11518	1	1	1	10	2013-04-01 17:20:48.166937
11519	1	1	1	12	2013-04-01 17:20:48.166937
11520	1	1	1	1	2013-04-01 17:20:48.166937
11521	1	1	1	5	2013-04-01 17:20:48.166937
11522	1	1	1	4	2013-04-01 17:20:48.166937
11523	1	1	1	2	2013-04-01 17:20:48.166937
11524	1	1	1	33	2013-04-01 17:20:48.166937
11525	1	3	3	17	2013-04-01 17:20:48.166937
11526	1	3	3	23	2013-04-01 17:20:48.166937
11527	1	3	3	24	2013-04-01 17:20:48.166937
11528	1	3	3	14	2013-04-01 17:20:48.166937
11529	1	3	3	25	2013-04-01 17:20:48.166937
11530	1	3	3	26	2013-04-01 17:20:48.166937
11531	1	3	3	27	2013-04-01 17:20:48.166937
11532	1	3	3	28	2013-04-01 17:20:48.166937
11533	1	3	3	29	2013-04-01 17:20:48.166937
11534	1	3	3	30	2013-04-01 17:20:48.166937
11535	1	3	4	18	2013-04-01 17:20:48.166937
11536	1	3	4	19	2013-04-01 17:20:48.166937
11537	1	3	5	21	2013-04-01 17:20:48.166937
11538	1	3	5	22	2013-04-01 17:20:48.166937
11539	1	3	5	31	2013-04-01 17:20:48.166937
11540	1	3	5	32	2013-04-01 17:20:48.166937
\.


--
-- Name: usuarios_programas_acessos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('usuarios_programas_acessos_id_seq', 11540, true);


SET search_path = paraformal, pg_catalog;

--
-- Name: atividades_registradas_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY atividades_registradas
    ADD CONSTRAINT atividades_registradas_pkey PRIMARY KEY (id);


--
-- Name: cenas_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cenas
    ADD CONSTRAINT cenas_pkey PRIMARY KEY (id);


--
-- Name: climas_paraformalidade_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY climas_paraformalidade
    ADD CONSTRAINT climas_paraformalidade_pkey PRIMARY KEY (id);


--
-- Name: climas_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY climas
    ADD CONSTRAINT climas_pkey PRIMARY KEY (id);


--
-- Name: colaboradores_paraformalidades_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY colaboradores_paraformalidades
    ADD CONSTRAINT colaboradores_paraformalidades_pkey PRIMARY KEY (id);


--
-- Name: condicionantes_ambientais_paraformalidade_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY condicionantes_ambientais_paraformalidade
    ADD CONSTRAINT condicionantes_ambientais_paraformalidade_pkey PRIMARY KEY (id);


--
-- Name: condicionantes_ambientais_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY condicionantes_ambientais
    ADD CONSTRAINT condicionantes_ambientais_pkey PRIMARY KEY (id);


--
-- Name: condicoes_ambientais_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY condicoes_ambientais
    ADD CONSTRAINT condicoes_ambientais_pkey PRIMARY KEY (id);


--
-- Name: corpo_numeros_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY corpo_numeros
    ADD CONSTRAINT corpo_numeros_pkey PRIMARY KEY (id);


--
-- Name: corpo_posicoes_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY corpo_posicoes
    ADD CONSTRAINT corpo_posicoes_pkey PRIMARY KEY (id);


--
-- Name: equipamento_instalacoes_paraformalidade_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY equipamento_instalacoes_paraformalidade
    ADD CONSTRAINT equipamento_instalacoes_paraformalidade_pkey PRIMARY KEY (id);


--
-- Name: equipamento_instalacoes_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY equipamento_instalacoes
    ADD CONSTRAINT equipamento_instalacoes_pkey PRIMARY KEY (id);


--
-- Name: equipamento_mobilidades_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY equipamento_mobilidades
    ADD CONSTRAINT equipamento_mobilidades_pkey PRIMARY KEY (id);


--
-- Name: equipamento_portes_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY equipamento_portes
    ADD CONSTRAINT equipamento_portes_pkey PRIMARY KEY (id);


--
-- Name: equipe_grupos_atividade_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY equipe_grupos_atividade
    ADD CONSTRAINT equipe_grupos_atividade_pkey PRIMARY KEY (id);


--
-- Name: equipe_registros_atividades_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY equipe_registros_atividades
    ADD CONSTRAINT equipe_registros_atividades_pkey PRIMARY KEY (id);


--
-- Name: espaco_localizacoes_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY espaco_localizacoes
    ADD CONSTRAINT espaco_localizacoes_pkey PRIMARY KEY (id);


--
-- Name: grupos_atividades_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grupos_atividades
    ADD CONSTRAINT grupos_atividades_pkey PRIMARY KEY (id);


--
-- Name: paraformalidades_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY paraformalidades
    ADD CONSTRAINT paraformalidades_pkey PRIMARY KEY (id);


--
-- Name: participacoes_equipe_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY participacoes_equipe
    ADD CONSTRAINT participacoes_equipe_pkey PRIMARY KEY (id);


--
-- Name: pessoa_procedencias_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pessoa_procedencias
    ADD CONSTRAINT pessoa_procedencias_pkey PRIMARY KEY (id);


--
-- Name: quantidades_registrada_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY quantidades_registrada
    ADD CONSTRAINT quantidades_registrada_pkey PRIMARY KEY (id);


--
-- Name: sentidos_paraformalidade_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sentidos_paraformalidade
    ADD CONSTRAINT sentidos_paraformalidade_pkey PRIMARY KEY (id);


--
-- Name: sentidos_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sentidos
    ADD CONSTRAINT sentidos_pkey PRIMARY KEY (id);


--
-- Name: turnos_ocorrencia_pkey; Type: CONSTRAINT; Schema: paraformal; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY turnos_ocorrencia
    ADD CONSTRAINT turnos_ocorrencia_pkey PRIMARY KEY (id);


SET search_path = public, pg_catalog;

--
-- Name: ci_sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY ci_sessions
    ADD CONSTRAINT ci_sessions_pkey PRIMARY KEY (session_id);


--
-- Name: cidades_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cidades
    ADD CONSTRAINT cidades_pkey PRIMARY KEY (id);


--
-- Name: empresas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY empresas
    ADD CONSTRAINT empresas_pkey PRIMARY KEY (id);


--
-- Name: enderecos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY enderecos
    ADD CONSTRAINT enderecos_pkey PRIMARY KEY (id);


--
-- Name: enderecos_tipos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY enderecos_tipos
    ADD CONSTRAINT enderecos_tipos_pkey PRIMARY KEY (id);


--
-- Name: estados_civis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY estados_civis
    ADD CONSTRAINT estados_civis_pkey PRIMARY KEY (id);


--
-- Name: grupos_acessos_empresas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grupos_acessos_empresas
    ADD CONSTRAINT grupos_acessos_empresas_pkey PRIMARY KEY (id);


--
-- Name: grupos_acessos_perfis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grupos_acessos_perfis
    ADD CONSTRAINT grupos_acessos_perfis_pkey PRIMARY KEY (id);


--
-- Name: grupos_acessos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grupos_acessos
    ADD CONSTRAINT grupos_acessos_pkey PRIMARY KEY (id);


--
-- Name: grupos_acessos_programas_permissoes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grupos_acessos_programas_permissoes
    ADD CONSTRAINT grupos_acessos_programas_permissoes_pkey PRIMARY KEY (id);


--
-- Name: grupos_acessos_programas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grupos_acessos_programas
    ADD CONSTRAINT grupos_acessos_programas_pkey PRIMARY KEY (id);


--
-- Name: log_fields_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY log_fields
    ADD CONSTRAINT log_fields_pkey PRIMARY KEY (id);


--
-- Name: log_fields_structures_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY log_fields_structures
    ADD CONSTRAINT log_fields_structures_pkey PRIMARY KEY (id);


--
-- Name: log_tables_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY log_tables
    ADD CONSTRAINT log_tables_pkey PRIMARY KEY (id);


--
-- Name: log_tables_structures_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY log_tables_structures
    ADD CONSTRAINT log_tables_structures_pkey PRIMARY KEY (id);


--
-- Name: parametros_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY parametros
    ADD CONSTRAINT parametros_pkey PRIMARY KEY (id);


--
-- Name: perfis_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY perfis
    ADD CONSTRAINT perfis_pkey PRIMARY KEY (id);


--
-- Name: perfis_programas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY perfis_programas
    ADD CONSTRAINT perfis_programas_pkey PRIMARY KEY (id);


--
-- Name: pessoas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pessoas
    ADD CONSTRAINT pessoas_pkey PRIMARY KEY (id);


--
-- Name: pessoas_tipos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pessoas_tipos
    ADD CONSTRAINT pessoas_tipos_pkey PRIMARY KEY (id);


--
-- Name: programas_parametros_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY programas_parametros
    ADD CONSTRAINT programas_parametros_pkey PRIMARY KEY (id);


--
-- Name: programas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY programas
    ADD CONSTRAINT programas_pkey PRIMARY KEY (id);


--
-- Name: sys_metodos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sys_metodos
    ADD CONSTRAINT sys_metodos_pkey PRIMARY KEY (id);


--
-- Name: sys_permissoes_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sys_permissoes
    ADD CONSTRAINT sys_permissoes_pkey PRIMARY KEY (id);


--
-- Name: telefones_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY telefones
    ADD CONSTRAINT telefones_pkey PRIMARY KEY (id);


--
-- Name: telefones_tipos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY telefones_tipos
    ADD CONSTRAINT telefones_tipos_pkey PRIMARY KEY (id);


--
-- Name: tipo_enderecos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_enderecos
    ADD CONSTRAINT tipo_enderecos_pkey PRIMARY KEY (id);


--
-- Name: unidades_federativas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY unidades_federativas
    ADD CONSTRAINT unidades_federativas_pkey PRIMARY KEY (id);


--
-- Name: uploads_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY uploads
    ADD CONSTRAINT uploads_pkey PRIMARY KEY (id);


--
-- Name: usuarios_grupos_acessos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuarios_grupos_acessos
    ADD CONSTRAINT usuarios_grupos_acessos_pkey PRIMARY KEY (id);


--
-- Name: usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- Name: usuarios_programas_acessos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuarios_programas_acessos
    ADD CONSTRAINT usuarios_programas_acessos_pkey PRIMARY KEY (id);


SET search_path = paraformal, pg_catalog;

--
-- Name: fk_cenas_1; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY cenas
    ADD CONSTRAINT fk_cenas_1 FOREIGN KEY (grupo_atividade_id) REFERENCES grupos_atividades(id);


--
-- Name: fk_climas_paraformalidade_1; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY climas_paraformalidade
    ADD CONSTRAINT fk_climas_paraformalidade_1 FOREIGN KEY (clima_id) REFERENCES climas(id);


--
-- Name: fk_climas_paraformalidade_2; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY climas_paraformalidade
    ADD CONSTRAINT fk_climas_paraformalidade_2 FOREIGN KEY (paraformalidade_id) REFERENCES paraformalidades(id);


--
-- Name: fk_colaboradores_grupos_atividade_2; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipe_grupos_atividade
    ADD CONSTRAINT fk_colaboradores_grupos_atividade_2 FOREIGN KEY (pessoa_id) REFERENCES public.pessoas(id);


--
-- Name: fk_colaboradores_grupos_atividade_3; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipe_grupos_atividade
    ADD CONSTRAINT fk_colaboradores_grupos_atividade_3 FOREIGN KEY (grupo_atividade_id) REFERENCES grupos_atividades(id);


--
-- Name: fk_colaboradores_paraformalidades_2; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY colaboradores_paraformalidades
    ADD CONSTRAINT fk_colaboradores_paraformalidades_2 FOREIGN KEY (pessoa_id) REFERENCES public.pessoas(id);


--
-- Name: fk_colaboradores_paraformalidades_3; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY colaboradores_paraformalidades
    ADD CONSTRAINT fk_colaboradores_paraformalidades_3 FOREIGN KEY (paraformalidade_id) REFERENCES paraformalidades(id);


--
-- Name: fk_condicionantes_ambientais_paraformalidade_1; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY condicionantes_ambientais_paraformalidade
    ADD CONSTRAINT fk_condicionantes_ambientais_paraformalidade_1 FOREIGN KEY (condicionante_ambiental_id) REFERENCES condicionantes_ambientais(id);


--
-- Name: fk_condicionantes_ambientais_paraformalidade_2; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY condicionantes_ambientais_paraformalidade
    ADD CONSTRAINT fk_condicionantes_ambientais_paraformalidade_2 FOREIGN KEY (paraformalidade_id) REFERENCES paraformalidades(id);


--
-- Name: fk_equipamento_instalacoes_paraformalidade_1; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipamento_instalacoes_paraformalidade
    ADD CONSTRAINT fk_equipamento_instalacoes_paraformalidade_1 FOREIGN KEY (equipamento_instalacao_id) REFERENCES equipamento_instalacoes(id);


--
-- Name: fk_equipamento_instalacoes_paraformalidade_2; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipamento_instalacoes_paraformalidade
    ADD CONSTRAINT fk_equipamento_instalacoes_paraformalidade_2 FOREIGN KEY (paraformalidade_id) REFERENCES paraformalidades(id);


--
-- Name: fk_equipe_grupos_atividade_3; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipe_grupos_atividade
    ADD CONSTRAINT fk_equipe_grupos_atividade_3 FOREIGN KEY (participacao_equipe_id) REFERENCES participacoes_equipe(id);


--
-- Name: fk_equipe_registros_atividades_1; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY equipe_registros_atividades
    ADD CONSTRAINT fk_equipe_registros_atividades_1 FOREIGN KEY (pessoa_id) REFERENCES public.pessoas(id);


--
-- Name: fk_grupos_atividades_1; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY grupos_atividades
    ADD CONSTRAINT fk_grupos_atividades_1 FOREIGN KEY (cidade_id) REFERENCES public.cidades(id);


--
-- Name: fk_imagens_paraformais_2; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY paraformalidades
    ADD CONSTRAINT fk_imagens_paraformais_2 FOREIGN KEY (upload_id) REFERENCES public.uploads(id);


--
-- Name: fk_imagens_paraformalidades_10; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY paraformalidades
    ADD CONSTRAINT fk_imagens_paraformalidades_10 FOREIGN KEY (quantidade_registrada_id) REFERENCES quantidades_registrada(id);


--
-- Name: fk_imagens_paraformalidades_11; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY paraformalidades
    ADD CONSTRAINT fk_imagens_paraformalidades_11 FOREIGN KEY (cena_id) REFERENCES cenas(id);


--
-- Name: fk_imagens_paraformalidades_12; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY paraformalidades
    ADD CONSTRAINT fk_imagens_paraformalidades_12 FOREIGN KEY (turno_ocorrencia_id) REFERENCES turnos_ocorrencia(id);


--
-- Name: fk_imagens_paraformalidades_13; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY paraformalidades
    ADD CONSTRAINT fk_imagens_paraformalidades_13 FOREIGN KEY (espaco_localizacao_id) REFERENCES espaco_localizacoes(id);


--
-- Name: fk_imagens_paraformalidades_4; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY paraformalidades
    ADD CONSTRAINT fk_imagens_paraformalidades_4 FOREIGN KEY (atividade_registrada_id) REFERENCES atividades_registradas(id);


--
-- Name: fk_imagens_paraformalidades_6; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY paraformalidades
    ADD CONSTRAINT fk_imagens_paraformalidades_6 FOREIGN KEY (equipamento_porte_id) REFERENCES equipamento_portes(id);


--
-- Name: fk_imagens_paraformalidades_7; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY paraformalidades
    ADD CONSTRAINT fk_imagens_paraformalidades_7 FOREIGN KEY (equipamento_mobilidade_id) REFERENCES equipamento_mobilidades(id);


--
-- Name: fk_imagens_paraformalidades_8; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY paraformalidades
    ADD CONSTRAINT fk_imagens_paraformalidades_8 FOREIGN KEY (corpo_numero_id) REFERENCES corpo_numeros(id);


--
-- Name: fk_imagens_paraformalidades_9; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY paraformalidades
    ADD CONSTRAINT fk_imagens_paraformalidades_9 FOREIGN KEY (corpo_posicao_id) REFERENCES corpo_posicoes(id);


--
-- Name: fk_sentidos_paraformalidade_2; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY sentidos_paraformalidade
    ADD CONSTRAINT fk_sentidos_paraformalidade_2 FOREIGN KEY (paraformalidade_id) REFERENCES paraformalidades(id);


--
-- Name: fk_sentidos_paraformalidades_1; Type: FK CONSTRAINT; Schema: paraformal; Owner: postgres
--

ALTER TABLE ONLY sentidos_paraformalidade
    ADD CONSTRAINT fk_sentidos_paraformalidades_1 FOREIGN KEY (sentido_id) REFERENCES sentidos(id);


SET search_path = public, pg_catalog;

--
-- Name: cidade_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pessoas
    ADD CONSTRAINT cidade_id_fkey FOREIGN KEY (cidade_id) REFERENCES cidades(id);


--
-- Name: fk_empresas_perfis_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY empresas_perfis
    ADD CONSTRAINT fk_empresas_perfis_1 FOREIGN KEY (empresa_id) REFERENCES empresas(id);


--
-- Name: fk_empresas_perfis_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY empresas_perfis
    ADD CONSTRAINT fk_empresas_perfis_2 FOREIGN KEY (perfil_id) REFERENCES perfis(id);


--
-- Name: fk_enderecos_fisicos_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY enderecos
    ADD CONSTRAINT fk_enderecos_fisicos_1 FOREIGN KEY (endereco_tipo_id) REFERENCES enderecos_tipos(id);


--
-- Name: fk_enderecos_fisicos_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY enderecos
    ADD CONSTRAINT fk_enderecos_fisicos_2 FOREIGN KEY (pessoa_id) REFERENCES pessoas(id);


--
-- Name: fk_grupos_acessos_empresas_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_empresas
    ADD CONSTRAINT fk_grupos_acessos_empresas_1 FOREIGN KEY (grupo_acesso_id) REFERENCES grupos_acessos(id);


--
-- Name: fk_grupos_acessos_empresas_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_empresas
    ADD CONSTRAINT fk_grupos_acessos_empresas_2 FOREIGN KEY (empresa_id) REFERENCES empresas(id);


--
-- Name: fk_grupos_acessos_perfis_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_perfis
    ADD CONSTRAINT fk_grupos_acessos_perfis_1 FOREIGN KEY (perfil_id) REFERENCES perfis(id);


--
-- Name: fk_grupos_acessos_perfis_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_perfis
    ADD CONSTRAINT fk_grupos_acessos_perfis_2 FOREIGN KEY (empresa_id) REFERENCES empresas(id);


--
-- Name: fk_grupos_acessos_perfis_3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_perfis
    ADD CONSTRAINT fk_grupos_acessos_perfis_3 FOREIGN KEY (grupo_acesso_id) REFERENCES grupos_acessos(id);


--
-- Name: fk_grupos_acessos_programas_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_programas
    ADD CONSTRAINT fk_grupos_acessos_programas_1 FOREIGN KEY (grupo_acesso_id) REFERENCES grupos_acessos(id);


--
-- Name: fk_grupos_acessos_programas_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_programas
    ADD CONSTRAINT fk_grupos_acessos_programas_2 FOREIGN KEY (empresa_id) REFERENCES empresas(id);


--
-- Name: fk_grupos_acessos_programas_3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_programas
    ADD CONSTRAINT fk_grupos_acessos_programas_3 FOREIGN KEY (perfil_id) REFERENCES perfis(id);


--
-- Name: fk_grupos_acessos_programas_4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_programas
    ADD CONSTRAINT fk_grupos_acessos_programas_4 FOREIGN KEY (programa_id) REFERENCES programas(id);


--
-- Name: fk_grupos_acessos_programas_permissoes_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_programas
    ADD CONSTRAINT fk_grupos_acessos_programas_permissoes_1 FOREIGN KEY (grupo_acesso_id) REFERENCES grupos_acessos(id);


--
-- Name: fk_grupos_acessos_programas_permissoes_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_programas_permissoes
    ADD CONSTRAINT fk_grupos_acessos_programas_permissoes_1 FOREIGN KEY (grupo_acesso_id) REFERENCES grupos_acessos(id);


--
-- Name: fk_grupos_acessos_programas_permissoes_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_acessos_programas_permissoes
    ADD CONSTRAINT fk_grupos_acessos_programas_permissoes_2 FOREIGN KEY (sys_metodo_id) REFERENCES sys_metodos(id);


--
-- Name: fk_log_fields_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_fields
    ADD CONSTRAINT fk_log_fields_1 FOREIGN KEY (log_table_id) REFERENCES log_tables(id);


--
-- Name: fk_log_fields_structures_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY log_fields_structures
    ADD CONSTRAINT fk_log_fields_structures_1 FOREIGN KEY (log_table_structure_id) REFERENCES log_tables_structures(id);


--
-- Name: fk_perfis_programas_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY perfis_programas
    ADD CONSTRAINT fk_perfis_programas_1 FOREIGN KEY (programa_id) REFERENCES programas(id);


--
-- Name: fk_perfis_programas_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY perfis_programas
    ADD CONSTRAINT fk_perfis_programas_2 FOREIGN KEY (perfil_id) REFERENCES perfis(id);


--
-- Name: fk_pessoas_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pessoas
    ADD CONSTRAINT fk_pessoas_1 FOREIGN KEY (estado_civil_id) REFERENCES estados_civis(id);


--
-- Name: fk_pessoas_foto_carteira; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pessoas
    ADD CONSTRAINT fk_pessoas_foto_carteira FOREIGN KEY (foto_carteira_id) REFERENCES uploads(id);


--
-- Name: fk_programas_parametros_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY programas_parametros
    ADD CONSTRAINT fk_programas_parametros_1 FOREIGN KEY (programa_id) REFERENCES programas(id);


--
-- Name: fk_sys_permissoes_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sys_permissoes
    ADD CONSTRAINT fk_sys_permissoes_1 FOREIGN KEY (sys_metodo_id) REFERENCES sys_metodos(id);


--
-- Name: fk_sys_permissoes_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY sys_permissoes
    ADD CONSTRAINT fk_sys_permissoes_2 FOREIGN KEY (usuario_id) REFERENCES usuarios(id);


--
-- Name: fk_telefones_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY telefones
    ADD CONSTRAINT fk_telefones_1 FOREIGN KEY (telefone_tipo_id) REFERENCES telefones_tipos(id);


--
-- Name: fk_telefones_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY telefones
    ADD CONSTRAINT fk_telefones_2 FOREIGN KEY (pessoa_id) REFERENCES pessoas(id);


--
-- Name: fk_usuarios_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT fk_usuarios_1 FOREIGN KEY (pessoa_id) REFERENCES pessoas(id);


--
-- Name: fk_usuarios_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT fk_usuarios_2 FOREIGN KEY (avatar_id) REFERENCES uploads(id);


--
-- Name: fk_usuarios_empresas_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_empresas
    ADD CONSTRAINT fk_usuarios_empresas_1 FOREIGN KEY (usuario_id) REFERENCES usuarios(id);


--
-- Name: fk_usuarios_empresas_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_empresas
    ADD CONSTRAINT fk_usuarios_empresas_2 FOREIGN KEY (empresa_id) REFERENCES empresas(id);


--
-- Name: fk_usuarios_grupos_acessos_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_grupos_acessos
    ADD CONSTRAINT fk_usuarios_grupos_acessos_1 FOREIGN KEY (grupo_acesso_id) REFERENCES grupos_acessos(id);


--
-- Name: fk_usuarios_grupos_acessos_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_grupos_acessos
    ADD CONSTRAINT fk_usuarios_grupos_acessos_2 FOREIGN KEY (usuario_id) REFERENCES usuarios(id);


--
-- Name: fk_usuarios_perfis_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_perfis
    ADD CONSTRAINT fk_usuarios_perfis_1 FOREIGN KEY (usuario_id) REFERENCES usuarios(id);


--
-- Name: fk_usuarios_perfis_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_perfis
    ADD CONSTRAINT fk_usuarios_perfis_2 FOREIGN KEY (perfil_id) REFERENCES perfis(id);


--
-- Name: fk_usuarios_perfis_3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_perfis
    ADD CONSTRAINT fk_usuarios_perfis_3 FOREIGN KEY (empresa_id) REFERENCES empresas(id);


--
-- Name: fk_usuarios_programas_acessos_1; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_programas_acessos
    ADD CONSTRAINT fk_usuarios_programas_acessos_1 FOREIGN KEY (usuario_id) REFERENCES usuarios(id);


--
-- Name: fk_usuarios_programas_acessos_2; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_programas_acessos
    ADD CONSTRAINT fk_usuarios_programas_acessos_2 FOREIGN KEY (programa_id) REFERENCES programas(id);


--
-- Name: fk_usuarios_programas_acessos_3; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_programas_acessos
    ADD CONSTRAINT fk_usuarios_programas_acessos_3 FOREIGN KEY (empresa_id) REFERENCES empresas(id);


--
-- Name: fk_usuarios_programas_acessos_4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_programas_acessos
    ADD CONSTRAINT fk_usuarios_programas_acessos_4 FOREIGN KEY (perfil_id) REFERENCES perfis(id);


--
-- Name: pessoas_orgao_emissor_rg_unidade_federativa_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pessoas
    ADD CONSTRAINT pessoas_orgao_emissor_rg_unidade_federativa_id FOREIGN KEY (orgao_emissor_rg_unidade_federativa_id) REFERENCES unidades_federativas(id);


--
-- Name: pessoas_pessoa_tipo_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY pessoas
    ADD CONSTRAINT pessoas_pessoa_tipo_id_fkey FOREIGN KEY (pessoa_tipo_id) REFERENCES pessoas_tipos(id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

