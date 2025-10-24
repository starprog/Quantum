-- World Recipes Database - Updated Recipe Data
-- Insert recipes for each country (15 total)

USE world_recipes;

-- Clear existing data
DELETE FROM recipes;

-- JAPAN RECIPES 🇯🇵
INSERT INTO recipes (country, name, ingredients, steps, image, source_link) VALUES
('Japan', 'Chicken Katsu', 
'Chicken breasts
Flour
Eggs
Panko breadcrumbs
Oil for frying
Salt
Pepper
Tonkatsu sauce
Steamed rice', 
'1. Pound chicken to even thickness
2. Season with salt and pepper
3. Dredge in flour, dip in beaten egg, then coat with panko
4. Fry in hot oil (350°F / 175°C) until golden brown, about 3–4 min each side
5. Drain on paper towels
6. Serve with tonkatsu sauce and rice', 
'https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=600&h=400&fit=crop',
'https://www.justonecookbook.com/katsu/'),

('Japan', 'Tonkatsu (Pork Cutlet)', 
'Pork loin
Flour
Egg
Panko breadcrumbs
Oil for frying
Salt
Pepper
Shredded cabbage
Tonkatsu sauce', 
'1. Trim fat and pound pork cutlets thin
2. Season with salt and pepper
3. Coat with flour → egg → panko
4. Fry at 350°F until crisp and golden (2–3 min each side)
5. Drain and slice
6. Serve with shredded cabbage and tonkatsu sauce', 
'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=600&h=400&fit=crop',
'https://www.seriouseats.com/tonkatsu-recipe'),

('Japan', 'Gyūdon (Beef Bowl)', 
'Thinly sliced beef
Onions
Soy sauce
Mirin
Sugar
Dashi stock
Steamed rice
Pickled ginger
Green onion', 
'1. Cook onions in dashi + soy sauce + mirin + sugar until soft
2. Add sliced beef; simmer until tender
3. Serve over steamed rice
4. Top with pickled ginger and green onion if desired', 
'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=600&h=400&fit=crop',
'https://www.justonecookbook.com/gyudon/');

-- INDIA RECIPES 🇮🇳
INSERT INTO recipes (country, name, ingredients, steps, image, source_link) VALUES
('India', 'Chicken Curry', 
'Chicken pieces
Onion
Tomato
Garlic
Ginger
Curry powder
Coconut milk or yogurt
Oil
Cilantro
Salt and spices', 
'1. Sauté onions, garlic, ginger until soft
2. Add spices (curry powder, chili, turmeric)
3. Add chicken and brown it
4. Add tomatoes and coconut milk/yogurt
5. Simmer 20–30 min until chicken is cooked and sauce thickens
6. Garnish with cilantro', 
'https://images.unsplash.com/photo-1565557623262-b51c2513a641?w=600&h=400&fit=crop',
'https://www.indianhealthyrecipes.com/chicken-curry-recipe/'),

('India', 'Lamb Curry', 
'Lamb pieces
Onion
Tomato
Garlic
Ginger
Curry paste or garam masala
Yogurt
Oil
Fresh mint
Basmati rice', 
'1. Brown lamb in oil; remove
2. Sauté onions, garlic, ginger
3. Stir in spices or curry paste
4. Add tomatoes and return lamb
5. Simmer 45 min–1 hr until tender
6. Finish with yogurt and garnish', 
'https://images.unsplash.com/photo-1588166524941-3bf61a9c41db?w=600&h=400&fit=crop',
'https://www.recipetineats.com/lamb-curry/'),

('India', 'Masala Tikki Curry', 
'Boiled potatoes
Peas
Garam masala
Chili powder
Flour
Oil
Curry sauce ingredients
Tomato
Onion
Spices', 
'1. Mash potatoes + peas + spices into patties
2. Coat lightly in flour
3. Shallow fry until golden
4. Prepare a curry sauce (tomato + onion + spices)
5. Add tikkis to sauce and simmer briefly', 
'https://images.unsplash.com/photo-1567188040759-fb8a883dc6d8?w=600&h=400&fit=crop',
'https://www.vegrecipesofindia.com/aloo-tikki-curry/');

-- MEXICO RECIPES 🇲🇽
INSERT INTO recipes (country, name, ingredients, steps, image, source_link) VALUES
('Mexico', 'Birria Tacos', 
'Beef chuck
Chili peppers
Garlic
Onion
Broth
Corn tortillas
Cheese
Spices', 
'1. Blend soaked dried chiles with garlic, onion, spices → make sauce
2. Marinate beef in sauce; simmer 3 hr until tender
3. Shred beef; dip tortillas in broth and fry slightly
4. Fill with beef + cheese, fold, and crisp both sides
5. Serve with broth for dipping', 
'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=600&h=400&fit=crop',
'https://www.mexicoinmykitchen.com/birria-recipe/'),

('Mexico', 'Quesadillas', 
'Tortillas
Cheese
Fillings (optional)
Butter or oil
Salsa
Guacamole', 
'1. Heat tortilla on skillet; add cheese and filling
2. Fold and cook both sides until cheese melts
3. Slice and serve with salsa or guacamole', 
'https://images.unsplash.com/photo-1618040996337-56904b7850b9?w=600&h=400&fit=crop',
'https://www.allrecipes.com/recipe/96547/quesadillas/'),

('Mexico', 'Cheesy Homemade Tacos', 
'Taco shells
Ground beef
Taco seasoning
Cheese
Lettuce
Tomato
Sour cream', 
'1. Brown beef with taco seasoning
2. Fill shells with beef and cheese
3. Add toppings and serve hot', 
'https://images.unsplash.com/photo-1565299507177-b0ac66763828?w=600&h=400&fit=crop',
'https://www.tacobell.com/food/tacos');

-- AMERICA RECIPES 🇺🇸
INSERT INTO recipes (country, name, ingredients, steps, image, source_link) VALUES
('America', 'Classic Burger', 
'Ground beef
Salt
Pepper
Burger buns
Cheese
Toppings (lettuce, tomato, onion)
Condiments', 
'1. Shape beef into patties; season with salt and pepper
2. Grill or pan-sear 3–4 min per side
3. Add cheese on top to melt
4. Toast buns and assemble with toppings', 
'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=600&h=400&fit=crop',
'https://www.allrecipes.com/recipe/49404/juiciest-hamburgers-ever/'),

('America', 'Fries', 
'Russet potatoes
Oil for frying
Salt', 
'1. Cut potatoes into sticks; soak in water 30 min
2. Dry well
3. Fry at 325°F until tender; remove
4. Fry again at 375°F until crisp and golden
5. Salt immediately', 
'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=600&h=400&fit=crop',
'https://www.seriouseats.com/the-best-roasted-potatoes-ever-recipe'),

('America', 'Chili Hot Dogs', 
'Hot dogs
Hot dog buns
Chili
Cheese
Onion
Mustard', 
'1. Grill or boil hot dogs
2. Warm chili
3. Place hot dogs in buns, top with chili, cheese, and onion', 
'https://images.unsplash.com/photo-1612392166886-ee7c818526ee?w=600&h=400&fit=crop',
'https://www.allrecipes.com/recipe/16354/chili-dog/');

-- ITALY RECIPES 🇮🇹
INSERT INTO recipes (country, name, ingredients, steps, image, source_link) VALUES
('Italy', 'Spaghetti', 
'Pasta
Tomato sauce
Garlic
Basil
Olive oil
Parmesan cheese', 
'1. Boil spaghetti until al dente
2. Sauté garlic in olive oil, add tomato sauce, simmer
3. Toss pasta in sauce, top with basil and cheese', 
'https://images.unsplash.com/photo-1551892374-ecf8754cf8b0?w=600&h=400&fit=crop',
'https://www.bonappetit.com/recipe/cacio-e-pepe'),

('Italy', 'Chicken Alfredo', 
'Chicken breast
Fettuccine
Cream
Butter
Parmesan
Garlic
Salt and pepper', 
'1. Cook fettuccine
2. Cook chicken and slice
3. In pan, melt butter, add garlic, cream, parmesan → simmer to thicken
4. Combine with pasta and chicken', 
'https://images.unsplash.com/photo-1621996346565-e3dbc92d2e36?w=600&h=400&fit=crop',
'https://www.allrecipes.com/recipe/22831/chicken-alfredo/'),

('Italy', 'Lasagna', 
'Lasagna noodles
Ground beef
Tomato sauce
Ricotta
Mozzarella
Parmesan
Egg', 
'1. Cook noodles; brown beef with sauce
2. Layer sauce, noodles, and cheeses in pan
3. Repeat layers; top with cheese
4. Bake at 375°F for 40 min
5. Rest 10 min before slicing', 
'https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=600&h=400&fit=crop',
'https://www.allrecipes.com/recipe/23600/worlds-best-lasagna/');