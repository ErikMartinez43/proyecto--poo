--
-- PostgreSQL database dump
--

\restrict 6WikBvwY6MMdSKE4ZL3U3NQbYNVTv9waBf7DUClj4aFE8zUjU51bAj0FjQplFk4

-- Dumped from database version 16.13 (Ubuntu 16.13-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.13 (Ubuntu 16.13-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: activacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.activacion (
    id integer NOT NULL,
    id_software integer NOT NULL,
    id_modulo integer NOT NULL
);


ALTER TABLE public.activacion OWNER TO postgres;

--
-- Name: activacion_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.activacion_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.activacion_id_seq OWNER TO postgres;

--
-- Name: activacion_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.activacion_id_seq OWNED BY public.activacion.id;


--
-- Name: modulo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.modulo (
    id integer NOT NULL,
    nombre character varying(100) NOT NULL,
    costo_adicional numeric(10,2) NOT NULL
);


ALTER TABLE public.modulo OWNER TO postgres;

--
-- Name: modulo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.modulo_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.modulo_id_seq OWNER TO postgres;

--
-- Name: modulo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.modulo_id_seq OWNED BY public.modulo.id;


--
-- Name: software; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.software (
    id integer NOT NULL,
    nombre character varying(100) NOT NULL,
    descripcion character varying(100),
    costo numeric(10,2) NOT NULL
);


ALTER TABLE public.software OWNER TO postgres;

--
-- Name: software_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.software_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.software_id_seq OWNER TO postgres;

--
-- Name: software_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.software_id_seq OWNED BY public.software.id;


--
-- Name: activacion id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.activacion ALTER COLUMN id SET DEFAULT nextval('public.activacion_id_seq'::regclass);


--
-- Name: modulo id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.modulo ALTER COLUMN id SET DEFAULT nextval('public.modulo_id_seq'::regclass);


--
-- Name: software id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.software ALTER COLUMN id SET DEFAULT nextval('public.software_id_seq'::regclass);


--
-- Data for Name: activacion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.activacion (id, id_software, id_modulo) FROM stdin;
12	2	3
\.


--
-- Data for Name: modulo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.modulo (id, nombre, costo_adicional) FROM stdin;
1	Soporte 24/7	49.99
2	Backup Premium	29.99
3	Licencia Educativa	19.99
\.


--
-- Data for Name: software; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.software (id, nombre, descripcion, costo) FROM stdin;
3	Sistema de inventario	control y gestion de productos en almacen	149.99
4	App de facturacion	Generacion automatica de facturas electronicas	129.99
2	Sistema de control	sistema de control de java avanzado	140.00
6	Anti virus	protege al SO de sofware malicioso	199.99
\.


--
-- Name: activacion_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.activacion_id_seq', 12, true);


--
-- Name: modulo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.modulo_id_seq', 3, true);


--
-- Name: software_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.software_id_seq', 6, true);


--
-- Name: activacion activacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.activacion
    ADD CONSTRAINT activacion_pkey PRIMARY KEY (id);


--
-- Name: modulo modulo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.modulo
    ADD CONSTRAINT modulo_pkey PRIMARY KEY (id);


--
-- Name: software software_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.software
    ADD CONSTRAINT software_pkey PRIMARY KEY (id);


--
-- Name: activacion activacion_id_modulo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.activacion
    ADD CONSTRAINT activacion_id_modulo_fkey FOREIGN KEY (id_modulo) REFERENCES public.modulo(id);


--
-- Name: activacion activacion_id_software_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.activacion
    ADD CONSTRAINT activacion_id_software_fkey FOREIGN KEY (id_software) REFERENCES public.software(id);


--
-- PostgreSQL database dump complete
--

\unrestrict 6WikBvwY6MMdSKE4ZL3U3NQbYNVTv9waBf7DUClj4aFE8zUjU51bAj0FjQplFk4

