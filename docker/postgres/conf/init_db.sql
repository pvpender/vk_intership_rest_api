CREATE TABLE IF NOT EXISTS users(
    id SERIAL PRIMARY KEY ,
    name VARCHAR(120) ,
    balance int ,
    CONSTRAINT positive_balance CHECK ( balance >= 0 )
);

CREATE TABLE IF NOT EXISTS quest(
    id SERIAL PRIMARY KEY ,
    name VARCHAR(120) ,
    cost int ,
    repeatable bool,
    CONSTRAINT positive_cost CHECK ( cost >= 0 )
);

CREATE TABLE IF NOT EXISTS achievement_history(
    id SERIAL PRIMARY KEY ,
    user_id int references users(id) ON DELETE CASCADE ,
    quest_id int references quest(id) ON DELETE CASCADE ,
    completion_date TIMESTAMP
);