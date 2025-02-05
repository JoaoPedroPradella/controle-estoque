PGDMP      
                 }            postgres    17.0    17.0 0    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            �           1262    5    postgres    DATABASE     �   CREATE DATABASE postgres WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE postgres;
                     postgres    false            �           0    0    DATABASE postgres    COMMENT     N   COMMENT ON DATABASE postgres IS 'default administrative connection database';
                        postgres    false    4847            �            1259    16391    cliente    TABLE       CREATE TABLE public.cliente (
    id integer NOT NULL,
    nome character varying(50) NOT NULL,
    cpf character varying(11),
    telefone character varying(15),
    uf character varying(2),
    municipio character varying(50),
    cep character varying(15)
);
    DROP TABLE public.cliente;
       public         heap r       postgres    false            �            1259    16390    cliente_id_seq    SEQUENCE     �   CREATE SEQUENCE public.cliente_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.cliente_id_seq;
       public               postgres    false    218            �           0    0    cliente_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.cliente_id_seq OWNED BY public.cliente.id;
          public               postgres    false    217            �            1259    16446 	   pagamento    TABLE     i   CREATE TABLE public.pagamento (
    id integer NOT NULL,
    descricao character varying(40) NOT NULL
);
    DROP TABLE public.pagamento;
       public         heap r       postgres    false            �            1259    16445    pagamento_id_seq    SEQUENCE     �   CREATE SEQUENCE public.pagamento_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.pagamento_id_seq;
       public               postgres    false    227            �           0    0    pagamento_id_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.pagamento_id_seq OWNED BY public.pagamento.id;
          public               postgres    false    226            �            1259    16406 
   prod_venda    TABLE     �   CREATE TABLE public.prod_venda (
    id integer NOT NULL,
    precounit numeric(18,2),
    quantidade numeric(9,2),
    produtoid integer NOT NULL,
    vendaid integer NOT NULL
);
    DROP TABLE public.prod_venda;
       public         heap r       postgres    false            �            1259    16405    prod_venda_id_seq    SEQUENCE     �   CREATE SEQUENCE public.prod_venda_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.prod_venda_id_seq;
       public               postgres    false    223            �           0    0    prod_venda_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.prod_venda_id_seq OWNED BY public.prod_venda.id;
          public               postgres    false    222            �            1259    16396    produto    TABLE     �   CREATE TABLE public.produto (
    id integer NOT NULL,
    descricao character varying(60) NOT NULL,
    preco numeric(18,2),
    quantidade numeric(9,2)
);
    DROP TABLE public.produto;
       public         heap r       postgres    false            �            1259    16395    produto_id_seq    SEQUENCE     �   CREATE SEQUENCE public.produto_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.produto_id_seq;
       public               postgres    false    220            �           0    0    produto_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.produto_id_seq OWNED BY public.produto.id;
          public               postgres    false    219            �            1259    16441    usuario    TABLE     �   CREATE TABLE public.usuario (
    id integer NOT NULL,
    nome character varying(50),
    email character varying(60),
    senha character varying(50)
);
    DROP TABLE public.usuario;
       public         heap r       postgres    false            �            1259    16440    usuario_id_seq    SEQUENCE     �   CREATE SEQUENCE public.usuario_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.usuario_id_seq;
       public               postgres    false    225            �           0    0    usuario_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.usuario_id_seq OWNED BY public.usuario.id;
          public               postgres    false    224            �            1259    16401    venda    TABLE     �   CREATE TABLE public.venda (
    numvenda integer NOT NULL,
    datahora timestamp without time zone,
    valortotal numeric(18,2),
    clienteid integer NOT NULL,
    pagamentoid integer NOT NULL
);
    DROP TABLE public.venda;
       public         heap r       postgres    false            �            1259    16463    venda_numvenda_seq    SEQUENCE     �   ALTER TABLE public.venda ALTER COLUMN numvenda ADD GENERATED BY DEFAULT AS IDENTITY (
    SEQUENCE NAME public.venda_numvenda_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);
            public               postgres    false    221            :           2604    16469 
   cliente id    DEFAULT     h   ALTER TABLE ONLY public.cliente ALTER COLUMN id SET DEFAULT nextval('public.cliente_id_seq'::regclass);
 9   ALTER TABLE public.cliente ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    217    218    218            >           2604    16470    pagamento id    DEFAULT     l   ALTER TABLE ONLY public.pagamento ALTER COLUMN id SET DEFAULT nextval('public.pagamento_id_seq'::regclass);
 ;   ALTER TABLE public.pagamento ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    227    226    227            <           2604    16471    prod_venda id    DEFAULT     n   ALTER TABLE ONLY public.prod_venda ALTER COLUMN id SET DEFAULT nextval('public.prod_venda_id_seq'::regclass);
 <   ALTER TABLE public.prod_venda ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    223    222    223            ;           2604    16472 
   produto id    DEFAULT     h   ALTER TABLE ONLY public.produto ALTER COLUMN id SET DEFAULT nextval('public.produto_id_seq'::regclass);
 9   ALTER TABLE public.produto ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    219    220    220            =           2604    16473 
   usuario id    DEFAULT     h   ALTER TABLE ONLY public.usuario ALTER COLUMN id SET DEFAULT nextval('public.usuario_id_seq'::regclass);
 9   ALTER TABLE public.usuario ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    224    225    225            �          0    16391    cliente 
   TABLE DATA           N   COPY public.cliente (id, nome, cpf, telefone, uf, municipio, cep) FROM stdin;
    public               postgres    false    218   �4       �          0    16446 	   pagamento 
   TABLE DATA           2   COPY public.pagamento (id, descricao) FROM stdin;
    public               postgres    false    227   �4       �          0    16406 
   prod_venda 
   TABLE DATA           S   COPY public.prod_venda (id, precounit, quantidade, produtoid, vendaid) FROM stdin;
    public               postgres    false    223   �4       �          0    16396    produto 
   TABLE DATA           C   COPY public.produto (id, descricao, preco, quantidade) FROM stdin;
    public               postgres    false    220   5       �          0    16441    usuario 
   TABLE DATA           9   COPY public.usuario (id, nome, email, senha) FROM stdin;
    public               postgres    false    225   5       �          0    16401    venda 
   TABLE DATA           W   COPY public.venda (numvenda, datahora, valortotal, clienteid, pagamentoid) FROM stdin;
    public               postgres    false    221   T5       �           0    0    cliente_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.cliente_id_seq', 1, true);
          public               postgres    false    217            �           0    0    pagamento_id_seq    SEQUENCE SET     >   SELECT pg_catalog.setval('public.pagamento_id_seq', 1, true);
          public               postgres    false    226            �           0    0    prod_venda_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.prod_venda_id_seq', 1, true);
          public               postgres    false    222            �           0    0    produto_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.produto_id_seq', 1, true);
          public               postgres    false    219            �           0    0    usuario_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.usuario_id_seq', 2, true);
          public               postgres    false    224            �           0    0    venda_numvenda_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.venda_numvenda_seq', 1, true);
          public               postgres    false    228            @           2606    16411    cliente pk_cliente 
   CONSTRAINT     P   ALTER TABLE ONLY public.cliente
    ADD CONSTRAINT pk_cliente PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.cliente DROP CONSTRAINT pk_cliente;
       public                 postgres    false    218            H           2606    16451    pagamento pk_pagamento 
   CONSTRAINT     T   ALTER TABLE ONLY public.pagamento
    ADD CONSTRAINT pk_pagamento PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.pagamento DROP CONSTRAINT pk_pagamento;
       public                 postgres    false    227            F           2606    16417    prod_venda pk_prod_venda 
   CONSTRAINT     V   ALTER TABLE ONLY public.prod_venda
    ADD CONSTRAINT pk_prod_venda PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.prod_venda DROP CONSTRAINT pk_prod_venda;
       public                 postgres    false    223            B           2606    16413    produto pk_produto 
   CONSTRAINT     P   ALTER TABLE ONLY public.produto
    ADD CONSTRAINT pk_produto PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.produto DROP CONSTRAINT pk_produto;
       public                 postgres    false    220            D           2606    16462    venda pk_venda 
   CONSTRAINT     R   ALTER TABLE ONLY public.venda
    ADD CONSTRAINT pk_venda PRIMARY KEY (numvenda);
 8   ALTER TABLE ONLY public.venda DROP CONSTRAINT pk_venda;
       public                 postgres    false    221            I           2606    16418    venda fk_venda_cliente    FK CONSTRAINT     y   ALTER TABLE ONLY public.venda
    ADD CONSTRAINT fk_venda_cliente FOREIGN KEY (clienteid) REFERENCES public.cliente(id);
 @   ALTER TABLE ONLY public.venda DROP CONSTRAINT fk_venda_cliente;
       public               postgres    false    218    4672    221            J           2606    16452    venda fk_venda_pagamento    FK CONSTRAINT        ALTER TABLE ONLY public.venda
    ADD CONSTRAINT fk_venda_pagamento FOREIGN KEY (pagamentoid) REFERENCES public.pagamento(id);
 B   ALTER TABLE ONLY public.venda DROP CONSTRAINT fk_venda_pagamento;
       public               postgres    false    221    4680    227            K           2606    16423     prod_venda fk_venda_prod_produto    FK CONSTRAINT     �   ALTER TABLE ONLY public.prod_venda
    ADD CONSTRAINT fk_venda_prod_produto FOREIGN KEY (produtoid) REFERENCES public.produto(id);
 J   ALTER TABLE ONLY public.prod_venda DROP CONSTRAINT fk_venda_prod_produto;
       public               postgres    false    223    4674    220            L           2606    16464    prod_venda fk_venda_prod_venda    FK CONSTRAINT     �   ALTER TABLE ONLY public.prod_venda
    ADD CONSTRAINT fk_venda_prod_venda FOREIGN KEY (vendaid) REFERENCES public.venda(numvenda);
 H   ALTER TABLE ONLY public.prod_venda DROP CONSTRAINT fk_venda_prod_venda;
       public               postgres    false    4676    223    221            �      x������ � �      �      x������ � �      �      x������ � �      �      x������ � �      �   %   x�3�tt��LL�uH�M���K���442����� xO      �      x������ � �     