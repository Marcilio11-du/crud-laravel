## Data Model for simple CRUD

### Entities and attributes

Para um sistema de controle dos componentes do computador

**Entidade:** Componente

**Atributos:**

- id
- nome
- marca
- categoria
- preco
- quantidade_em_estoque
- data_cadastro

---

## Data model for main CRUD

## Entities and attributes

Para um sistema de gerenciamento de artigos na internet

### Entidades:

- **Categorias**(id, nome, descricao)
- **Artigos**(id, title, conteudo, data_publicacao)
- **Utilizador**(id, p_nome, sb_nome, data_nascimento)

### Relacionamentos

Utilizador N:N Artigos
Categorias 1:N Artigos

## Modelo Relacional com auditoria e softdelete


 - **Categorias**(id, nome, descricao, createdAt, updatedAt, deleteAt)
 - **Utilizador**(id, p_nome, sb_nome, data_nascimento, createdAt, updatedAt, deleteAt)
 - **Artigos**(id, title, conteudo, data_publicacao, id_categoria, createdAt, updatedAt, deleteAt)
 - **Artigo_Utilizador**(id, id_artigo_id_utilizador, createdAt, updatedAt, deleteAt)