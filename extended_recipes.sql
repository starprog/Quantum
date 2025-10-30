-- ========================================
-- EXTENDED WORLD RECIPES - 40 RECIPES TOTAL
-- ========================================
-- Additional 25 recipes to add to existing database
-- 5 more recipes for each country (Japan, India, Mexico, America, Italy)
-- ========================================

USE world_recipes;

-- JAPAN RECIPES 🇯🇵 (5 additional recipes)
INSERT INTO recipes (country, name, ingredients, steps, image, source_link) VALUES
('Japan', 'Chicken Teriyaki', 
'Chicken thighs
Soy sauce
Mirin
Sake
Sugar
Ginger
Garlic
Green onions
Sesame seeds
Steamed rice', 
'1. Cut chicken into bite-sized pieces
2. Mix soy sauce, mirin, sake, and sugar for teriyaki sauce
3. Marinate chicken in half the sauce for 30 minutes
4. Heat oil in pan and cook chicken until golden
5. Add remaining sauce and cook until glossy
6. Garnish with green onions and sesame seeds
7. Serve over steamed rice', 
'https://images.unsplash.com/photo-1546833999-b9f581a1996d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Japan', 'Yakitori', 
'Chicken thighs
Chicken breast
Leeks
Bell peppers
Soy sauce
Mirin
Sake
Sugar
Bamboo skewers', 
'1. Cut chicken into cubes and vegetables into pieces
2. Thread chicken and vegetables onto skewers alternating
3. Mix soy sauce, mirin, sake, and sugar for tare sauce
4. Grill skewers over medium heat, turning frequently
5. Brush with tare sauce during last few minutes
6. Cook until chicken is done and slightly charred
7. Serve hot with extra sauce on side', 
'https://images.unsplash.com/photo-1583394838336-acd977736f90?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Japan', 'Chicken Curry (Japanese Style)', 
'Chicken thighs
Onions
Carrots
Potatoes
Japanese curry roux blocks
Chicken stock
Vegetable oil
Garlic
Ginger
Steamed rice', 
'1. Cut chicken, onions, carrots, and potatoes into chunks
2. Heat oil and sauté onions until translucent
3. Add garlic and ginger, cook 1 minute
4. Add chicken and cook until browned
5. Add carrots and potatoes, cover with stock
6. Simmer 20 minutes until vegetables are tender
7. Add curry roux blocks and stir until dissolved
8. Simmer 10 more minutes until thickened
9. Serve over steamed rice', 
'https://images.unsplash.com/photo-1585937421612-70a008356fbe?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Japan', 'Oyakodon (Chicken and Egg Bowl)', 
'Chicken thighs
Eggs
Onions
Dashi stock
Soy sauce
Mirin
Sugar
Green onions
Steamed rice', 
'1. Slice chicken and onions thinly
2. Mix dashi, soy sauce, mirin, and sugar for sauce
3. Heat sauce in pan and add chicken and onions
4. Cook until chicken is done and onions are soft
5. Beat eggs lightly and pour over chicken
6. Cover and cook until eggs are just set
7. Slide over hot rice in bowl
8. Garnish with chopped green onions', 
'https://images.unsplash.com/photo-1605333396293-49b999616a1f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Japan', 'Tempura', 
'Shrimp
Mixed vegetables (eggplant, sweet potato, green beans)
Tempura flour
Ice water
Egg
Oil for frying
Tentsuyu dipping sauce
Daikon radish
Ginger', 
'1. Prepare vegetables by cutting into uniform pieces
2. Clean and devein shrimp, leaving tails on
3. Make tempura batter with flour, egg, and ice water (keep lumpy)
4. Heat oil to 340°F (170°C)
5. Dip ingredients in batter and fry until light golden
6. Drain on paper towels
7. Serve immediately with tentsuyu sauce
8. Garnish with grated daikon and ginger', 
'https://images.unsplash.com/photo-1606491956689-2ea866880c84?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

-- INDIA RECIPES 🇮🇳 (5 additional recipes)
('India', 'Paneer Tikka', 
'Paneer cheese
Yogurt
Ginger-garlic paste
Red chili powder
Turmeric
Garam masala
Cumin powder
Lemon juice
Bell peppers
Onions
Oil', 
'1. Cut paneer into cubes and vegetables into chunks
2. Mix yogurt with all spices, ginger-garlic paste, and lemon juice
3. Marinate paneer and vegetables for 2 hours
4. Thread onto skewers alternating paneer and vegetables
5. Grill or bake at 400°F for 15-20 minutes
6. Turn occasionally and brush with oil
7. Cook until golden and slightly charred
8. Serve hot with mint chutney', 
'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('India', 'Chole (Chickpea Curry)', 
'Chickpeas (dried or canned)
Onions
Tomatoes
Ginger-garlic paste
Cumin seeds
Coriander powder
Turmeric
Red chili powder
Garam masala
Bay leaves
Oil
Cilantro', 
'1. If using dried chickpeas, soak overnight and boil until tender
2. Heat oil and add cumin seeds and bay leaves
3. Add chopped onions and sauté until golden
4. Add ginger-garlic paste and cook 1 minute
5. Add tomatoes and all spices, cook until oil separates
6. Add chickpeas with cooking liquid
7. Simmer 20 minutes until flavors meld
8. Garnish with cilantro and serve with rice or bread', 
'https://images.unsplash.com/photo-1585937421612-70a008356fbe?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('India', 'Aloo Gobi', 
'Potatoes
Cauliflower
Onions
Tomatoes
Ginger-garlic paste
Turmeric
Cumin seeds
Coriander powder
Red chili powder
Garam masala
Oil
Cilantro', 
'1. Cut potatoes and cauliflower into medium pieces
2. Heat oil and add cumin seeds
3. Add potatoes and fry until golden, remove
4. In same oil, add cauliflower and fry lightly, remove
5. Add onions and cook until translucent
6. Add ginger-garlic paste and spices
7. Add tomatoes and cook until soft
8. Return potatoes and cauliflower to pan
9. Cover and cook until vegetables are tender
10. Garnish with cilantro', 
'https://images.unsplash.com/photo-1565557623262-b51c2513a641?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('India', 'Biryani', 
'Basmati rice
Chicken or mutton
Yogurt
Onions
Mint leaves
Cilantro
Ginger-garlic paste
Biryani masala
Saffron
Milk
Ghee
Whole spices', 
'1. Soak rice for 30 minutes, then parboil with whole spices
2. Marinate meat with yogurt, ginger-garlic paste, and spices
3. Deep fry sliced onions until golden and crispy
4. Cook marinated meat until 70% done
5. Soak saffron in warm milk
6. Layer rice and meat alternately in heavy-bottomed pot
7. Top with fried onions, mint, cilantro, and saffron milk
8. Cover and cook on dum (low heat) for 45 minutes
9. Serve with raita and boiled eggs', 
'https://images.unsplash.com/photo-1563379091339-03246963d51a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('India', 'Masala Dosa', 
'Rice
Urad dal
Fenugreek seeds
Potatoes
Onions
Green chilies
Ginger
Curry leaves
Mustard seeds
Turmeric
Oil
Salt', 
'1. Soak rice and dal separately for 4-6 hours
2. Grind to smooth batter, ferment overnight
3. For filling: boil and mash potatoes
4. Heat oil, add mustard seeds and curry leaves
5. Add onions, chilies, ginger, and turmeric
6. Mix in mashed potatoes and cook
7. Heat non-stick pan and spread thin layer of batter
8. Cook until golden, add filling and fold
9. Serve hot with coconut chutney and sambar', 
'https://images.unsplash.com/photo-1606491956689-2ea866880c84?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

-- MEXICO RECIPES 🇲🇽 (5 additional recipes)
('Mexico', 'Chiles Rellenos', 
'Poblano peppers
Cheese (Monterey Jack or Oaxaca)
Eggs
Flour
Oil for frying
Tomato sauce
Onions
Garlic
Salt
Pepper', 
'1. Roast poblanos over open flame until charred
2. Place in plastic bag to steam, then peel skin
3. Make small slit and remove seeds carefully
4. Stuff with cheese and close opening
5. Separate eggs and beat whites to stiff peaks
6. Fold in beaten yolks
7. Dredge stuffed peppers in flour, then dip in egg
8. Fry in hot oil until golden
9. Serve with warm tomato sauce', 
'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Mexico', 'Pozole Rojo', 
'Pork shoulder
Hominy (pozole corn)
Guajillo chilies
Ancho chilies
Onions
Garlic
Bay leaves
Oregano
Cabbage
Radishes
Lime
Tostadas', 
'1. Boil pork shoulder with onion, garlic, and bay leaves until tender
2. Shred meat and strain broth
3. Toast and soak dried chilies, then blend with garlic
4. Strain chile mixture and add to broth
5. Add hominy and simmer 30 minutes
6. Season with salt and oregano
7. Serve in bowls with shredded meat
8. Garnish with cabbage, radishes, and lime
9. Serve with tostadas', 
'https://images.unsplash.com/photo-1565299585323-38174c13c7d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Mexico', 'Carnitas', 
'Pork shoulder
Lard or vegetable oil
Orange juice
Lime juice
Onions
Garlic
Bay leaves
Thyme
Salt
Pepper
Corn tortillas
Cilantro
White onions', 
'1. Cut pork shoulder into large chunks
2. Season with salt and pepper
3. Heat lard in heavy pot and brown pork on all sides
4. Add orange juice, lime juice, onions, garlic, and herbs
5. Cover and cook slowly for 2-3 hours until tender
6. Remove lid and cook until liquid evaporates
7. Increase heat to crisp the edges
8. Shred meat with forks
9. Serve in warm tortillas with cilantro and onions', 
'https://images.unsplash.com/photo-1615870216519-2f9fa2707e93?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Mexico', 'Mole Poblano', 
'Chicken
Mulato chilies
Ancho chilies
Pasilla chilies
Chipotle chilies
Tomatoes
Tomatillos
Onions
Garlic
Chocolate
Almonds
Sesame seeds
Spices', 
'1. Toast and soak various dried chilies
2. Roast tomatoes, tomatillos, onions, and garlic
3. Fry almonds and sesame seeds until golden
4. Blend chilies with roasted vegetables and nuts
5. Strain mixture and fry in oil for 30 minutes
6. Add chocolate and spices, simmer 1 hour
7. Cook chicken separately until tender
8. Combine chicken with mole sauce
9. Serve with rice and warm tortillas', 
'https://images.unsplash.com/photo-1565299507177-b0ac66763828?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Mexico', 'Elote (Mexican Street Corn)', 
'Corn on the cob
Mayonnaise
Mexican crema or sour cream
Cotija cheese
Chili powder
Lime juice
Cilantro
Butter
Salt', 
'1. Grill corn over medium-high heat, turning frequently
2. Cook until kernels are lightly charred all around
3. Mix mayonnaise with a little lime juice
4. Brush hot corn with butter
5. Spread mayo mixture all over corn
6. Sprinkle with crumbled cotija cheese
7. Dust with chili powder
8. Garnish with cilantro and lime wedges
9. Serve immediately while hot', 
'https://images.unsplash.com/photo-1551218808-94e220e084d2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

-- AMERICA RECIPES 🇺🇸 (5 additional recipes)
('America', 'BBQ Ribs', 
'Pork ribs
Brown sugar
Paprika
Garlic powder
Onion powder
Chili powder
Cumin
Salt
Pepper
BBQ sauce
Apple cider vinegar', 
'1. Remove membrane from back of ribs
2. Mix all dry spices for rub
3. Coat ribs generously with spice rub
4. Let sit at room temperature for 1 hour
5. Preheat grill or smoker to 225°F
6. Cook ribs bone-side down for 3 hours
7. Wrap in foil with butter and brown sugar
8. Cook 2 more hours until tender
9. Brush with BBQ sauce and grill 15 minutes
10. Let rest 10 minutes before cutting', 
'https://images.unsplash.com/photo-1544025162-d76694265947?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('America', 'Fried Chicken', 
'Chicken pieces
Buttermilk
Flour
Cornstarch
Paprika
Garlic powder
Onion powder
Cayenne pepper
Salt
Pepper
Oil for frying', 
'1. Marinate chicken in buttermilk for 4-24 hours
2. Mix flour with all spices and seasonings
3. Remove chicken from buttermilk, let excess drip
4. Dredge chicken in seasoned flour mixture
5. Let coated chicken rest 15 minutes
6. Heat oil to 350°F in heavy pot
7. Fry chicken pieces until golden brown and cooked through
8. Internal temperature should reach 165°F
9. Drain on paper towels and serve hot', 
'https://images.unsplash.com/photo-1569058242253-92a9c755a0ec?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('America', 'Mac and Cheese', 
'Elbow macaroni
Butter
Flour
Milk
Heavy cream
Cheddar cheese
Gruyere cheese
Parmesan cheese
Mustard powder
Nutmeg
Salt
Pepper
Breadcrumbs', 
'1. Cook macaroni according to package directions, drain
2. Melt butter in large pot and whisk in flour
3. Cook roux for 2 minutes, then gradually add milk
4. Whisk until smooth and thickened
5. Add cheeses gradually, stirring until melted
6. Season with mustard powder, nutmeg, salt, and pepper
7. Fold in cooked macaroni
8. Transfer to baking dish and top with breadcrumbs
9. Bake at 375°F for 25-30 minutes until bubbly', 
'https://images.unsplash.com/photo-1543826173-e1f00b75e6b6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('America', 'Apple Pie', 
'Pie crust (2 crusts)
Apples (Granny Smith, Honeycrisp)
Sugar
Brown sugar
Flour
Cinnamon
Nutmeg
Lemon juice
Butter
Egg wash', 
'1. Peel and slice apples into thin wedges
2. Toss apples with sugars, flour, spices, and lemon juice
3. Roll out bottom crust and place in pie pan
4. Fill with apple mixture and dot with butter
5. Cover with top crust and crimp edges
6. Cut vents in top crust
7. Brush with egg wash and sprinkle with sugar
8. Bake at 425°F for 15 minutes, then 350°F for 35-45 minutes
9. Cool completely before serving', 
'https://images.unsplash.com/photo-1621743478914-cc8a86d7e7b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('America', 'Clam Chowder', 
'Clams (fresh or canned)
Bacon
Onions
Celery
Potatoes
Flour
Heavy cream
Fish stock
Bay leaves
Thyme
Salt
Pepper
Crackers', 
'1. Cook bacon until crispy, remove and chop
2. Sauté onions and celery in bacon fat until soft
3. Add diced potatoes and cook 5 minutes
4. Sprinkle flour over vegetables and stir
5. Gradually add fish stock and bring to boil
6. Add bay leaves and thyme, simmer until potatoes are tender
7. Add clams and their juice, simmer 5 minutes
8. Stir in heavy cream and cooked bacon
9. Season with salt and pepper
10. Serve hot with crackers', 
'https://images.unsplash.com/photo-1547592166-23ac45744acd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

-- ITALY RECIPES 🇮🇹 (5 additional recipes)
('Italy', 'Risotto alla Milanese', 
'Arborio rice
Beef stock
White wine
Onions
Saffron
Parmesan cheese
Butter
Olive oil
Salt
Pepper', 
'1. Heat beef stock and keep warm
2. Soak saffron in a little warm stock
3. Heat olive oil and butter in heavy pan
4. Sauté minced onions until translucent
5. Add rice and stir to coat with fat
6. Add wine and stir until absorbed
7. Add warm stock one ladle at a time, stirring constantly
8. Cook 18-20 minutes until rice is creamy but still firm
9. Stir in saffron mixture and Parmesan
10. Finish with butter and serve immediately', 
'https://images.unsplash.com/photo-1476124369491-e7addf5db371?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Italy', 'Osso Buco', 
'Veal shanks
Flour
Onions
Carrots
Celery
Tomatoes
White wine
Beef stock
Gremolata (lemon zest, garlic, parsley)
Olive oil
Salt
Pepper', 
'1. Dredge veal shanks in flour seasoned with salt and pepper
2. Brown shanks in olive oil on all sides, remove
3. Sauté onions, carrots, and celery until soft
4. Add tomatoes and cook until reduced
5. Return veal to pot and add wine
6. Add enough stock to partially cover meat
7. Cover and braise in 325°F oven for 2 hours
8. Turn shanks once during cooking
9. Make gremolata by mixing lemon zest, garlic, and parsley
10. Serve with gremolata and risotto or polenta', 
'https://images.unsplash.com/photo-1565299507177-b0ac66763828?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Italy', 'Tiramisu', 
'Ladyfinger cookies
Strong espresso coffee
Mascarpone cheese
Eggs
Sugar
Cocoa powder
Dark rum or Marsala wine
Heavy cream', 
'1. Brew strong espresso and let cool, add rum if using
2. Separate eggs and beat yolks with sugar until pale
3. Add mascarpone to yolk mixture and beat until smooth
4. Whip cream to soft peaks and fold into mascarpone
5. Beat egg whites to stiff peaks and fold in gently
6. Quickly dip ladyfingers in coffee and arrange in dish
7. Spread half the mascarpone mixture over cookies
8. Add another layer of dipped ladyfingers
9. Top with remaining mascarpone mixture
10. Chill 4 hours or overnight, dust with cocoa before serving', 
'https://images.unsplash.com/photo-1571877227200-a0d98ea607e9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Italy', 'Pesto Genovese', 
'Fresh basil leaves
Pine nuts
Garlic
Parmesan cheese
Pecorino Romano cheese
Extra virgin olive oil
Salt
Pasta for serving', 
'1. Wash and dry basil leaves gently
2. Toast pine nuts lightly in dry pan until golden
3. In food processor, pulse garlic and pine nuts
4. Add basil leaves and pulse until roughly chopped
5. With processor running, slowly drizzle in olive oil
6. Add grated cheeses and pulse to combine
7. Season with salt to taste
8. Toss with hot pasta and a little pasta cooking water
9. Serve immediately with extra cheese', 
'https://images.unsplash.com/photo-1621996346565-e3dbc353d2e5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL),

('Italy', 'Cannoli', 
'Cannoli shells (store-bought or homemade)
Ricotta cheese
Powdered sugar
Vanilla extract
Orange zest
Mini chocolate chips
Pistachio nuts (chopped)
Candied fruit (optional)', 
'1. Strain ricotta cheese through fine mesh for 2 hours
2. Mix ricotta with powdered sugar and vanilla
3. Add orange zest and mix well
4. Fold in chocolate chips gently
5. Transfer mixture to piping bag
6. Just before serving, pipe filling into cannoli shells
7. Dip ends in chopped pistachios or candied fruit
8. Dust with powdered sugar
9. Serve immediately to prevent shells from softening', 
'https://images.unsplash.com/photo-1606491956689-2ea866880c84?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 
NULL);

-- Update recipe counts
UPDATE recipes SET created_at = NOW() WHERE country IN ('Japan', 'India', 'Mexico', 'America', 'Italy');

-- Show final counts
SELECT country, COUNT(*) as total_recipes FROM recipes GROUP BY country ORDER BY country;