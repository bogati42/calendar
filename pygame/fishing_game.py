# Pygame Fishing Game
# Make sure you have pygame installed: pip install pygame

import pygame
import random
import sys
import time

# Initialize Pygame
pygame.init()
pygame.font.init() # Initialize font module

# --- Game Constants ---
SCREEN_WIDTH = 800
SCREEN_HEIGHT = 600
FPS = 60

# Colors
BLUE = (135, 206, 250)  # Sky blue
WATER_BLUE = (64, 164, 223)
GREEN = (34, 139, 34)   # Grass green
BLACK = (0, 0, 0)
WHITE = (255, 255, 255)
RED = (255, 0, 0)
YELLOW = (255, 255, 0)
BROWN = (139, 69, 19) # For the fishing rod

# Game states
STATE_IDLE = "idle"             # Ready to cast
STATE_CASTING = "casting"       # Line is being cast (animation)
STATE_WAITING = "waiting"       # Line is in water, waiting for a bite
STATE_FISH_BITING = "biting"    # Fish is biting, player needs to react
STATE_REELING = "reeling"       # Player successfully hooked, reeling in
STATE_CAUGHT_FISH = "caught"    # Display caught fish
STATE_MISSED_FISH = "missed"    # Player missed the hook or fish got away

# Fishing parameters
CAST_ANIMATION_SPEED = 5 # Pixels per frame for line extending
MAX_CAST_DISTANCE = 300
BOBBER_SIZE = 10
BITE_WINDOW_DURATION = 1.0  # Seconds player has to react
WAIT_FOR_BITE_MIN_TIME = 2.0 # Seconds
WAIT_FOR_BITE_MAX_TIME = 8.0 # Seconds
REEL_ANIMATION_DURATION = 1.5 # Seconds

# Fish types and their rarity (lower number = rarer, for weighting)
# For simplicity, we'll just use names and a generic "value" of 1 for score
FISH_TYPES = {
    "Minnow": 10,
    "Bluegill": 8,
    "Perch": 7,
    "Bass": 5,
    "Trout": 3,
    "Golden Carp": 1 # Rare
}

# --- Setup Screen ---
screen = pygame.display.set_mode((SCREEN_WIDTH, SCREEN_HEIGHT))
pygame.display.set_caption("Pond Fishing Adventure")
clock = pygame.time.Clock()

# --- Font ---
try:
    game_font_small = pygame.font.SysFont("Arial", 24)
    game_font_medium = pygame.font.SysFont("Arial", 36)
    game_font_large = pygame.font.SysFont("Arial", 48)
except pygame.error as e:
    print(f"Font loading error: {e}. Using default font.")
    game_font_small = pygame.font.Font(None, 30) # Default if Arial not found
    game_font_medium = pygame.font.Font(None, 42)
    game_font_large = pygame.font.Font(None, 54)


# --- Game Variables ---
current_state = STATE_IDLE
score = 0

# Player/Rod position (simplified)
player_x = 150
player_y = SCREEN_HEIGHT - 150 # Standing on the "grass"

# Line and Bobber variables
line_start_pos = (player_x + 30, player_y - 40) # Tip of the rod
line_end_pos = line_start_pos
bobber_pos = None
is_line_cast = False
cast_distance_current = 0

# Timers
bite_timer = 0
reaction_timer = 0
message_display_timer = 0
current_message = ""
current_message_duration = 0

# Fish details
last_caught_fish_name = ""

# --- Helper Functions ---

def draw_text(text, font, color, surface, x, y, center=False):
    """Helper function to draw text on the screen."""
    text_obj = font.render(text, True, color)
    text_rect = text_obj.get_rect()
    if center:
        text_rect.center = (x, y)
    else:
        text_rect.topleft = (x, y)
    surface.blit(text_obj, text_rect)

def get_random_fish():
    """Selects a fish based on rarity/weight."""
    fish_names = list(FISH_TYPES.keys())
    weights = [FISH_TYPES[name] for name in fish_names]
    return random.choices(fish_names, weights=weights, k=1)[0]

def display_timed_message(message, duration, font_size="medium"):
    """Sets up a message to be displayed for a certain duration."""
    global current_message, message_display_timer, current_message_duration
    current_message = message
    current_message_duration = duration
    message_display_timer = time.time() # Start timer now

    if font_size == "small":
        return game_font_small.render(message, True, BLACK)
    elif font_size == "large":
        return game_font_large.render(message, True, BLACK)
    else: # medium
        return game_font_medium.render(message, True, BLACK)


# --- Game Loop ---
running = True
while running:
    # Event Handling
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False
        if event.type == pygame.KEYDOWN:
            if event.key == pygame.K_SPACE:
                if current_state == STATE_IDLE:
                    current_state = STATE_CASTING
                    cast_distance_current = 0 # Reset for animation
                    is_line_cast = False
                    print("Action: Start Casting")

                elif current_state == STATE_FISH_BITING:
                    # Player reacted in time
                    current_state = STATE_REELING
                    last_caught_fish_name = get_random_fish()
                    score += 1
                    reaction_timer = 0 # Reset reaction timer
                    display_timed_message(f"Hooked a {last_caught_fish_name}!", REEL_ANIMATION_DURATION + 0.5)
                    print(f"Action: Hooked! Fish: {last_caught_fish_name}")


    # --- Game State Logic ---

    if current_state == STATE_CASTING:
        # Animate the line casting out
        cast_distance_current += CAST_ANIMATION_SPEED
        line_end_pos = (line_start_pos[0] + cast_distance_current, line_start_pos[1])
        if cast_distance_current >= MAX_CAST_DISTANCE:
            cast_distance_current = MAX_CAST_DISTANCE # Cap distance
            line_end_pos = (line_start_pos[0] + MAX_CAST_DISTANCE, line_start_pos[1])
            bobber_pos = (line_end_pos[0], WATER_BLUE_TOP + BOBBER_SIZE*2) # Bobber on water surface
            is_line_cast = True
            current_state = STATE_WAITING
            bite_timer = time.time() + random.uniform(WAIT_FOR_BITE_MIN_TIME, WAIT_FOR_BITE_MAX_TIME)
            print(f"State: Waiting for bite. Bite expected around: {bite_timer - time.time():.2f}s")


    elif current_state == STATE_WAITING:
        if time.time() >= bite_timer:
            current_state = STATE_FISH_BITING
            reaction_timer = time.time() + BITE_WINDOW_DURATION # Start reaction window
            print("State: Fish Biting! React fast!")


    elif current_state == STATE_FISH_BITING:
        if time.time() >= reaction_timer: # Player missed the window
            current_state = STATE_MISSED_FISH
            display_timed_message("The fish got away!", 2.0)
            print("State: Missed fish (too slow)")


    elif current_state == STATE_REELING:
        # Simple reeling animation (line retracts)
        # For simplicity, we just wait for the message duration
        if not (current_message and time.time() < message_display_timer + current_message_duration):
            current_state = STATE_CAUGHT_FISH
            display_timed_message(f"You caught: {last_caught_fish_name}!", 2.5, font_size="large")
            print(f"State: Caught {last_caught_fish_name}")


    elif current_state == STATE_CAUGHT_FISH or current_state == STATE_MISSED_FISH:
        # Wait for the message to disappear, then reset
        if not (current_message and time.time() < message_display_timer + current_message_duration):
            is_line_cast = False
            bobber_pos = None
            line_end_pos = line_start_pos
            current_state = STATE_IDLE
            last_caught_fish_name = ""
            print("State: Idle (reset after catch/miss)")


    # --- Drawing ---
    # Background
    screen.fill(BLUE) # Sky
    pygame.draw.rect(screen, GREEN, (0, SCREEN_HEIGHT - 200, SCREEN_WIDTH, 200)) # Grass
    WATER_BLUE_TOP = SCREEN_HEIGHT // 2 - 50
    pygame.draw.rect(screen, WATER_BLUE, (0, WATER_BLUE_TOP, SCREEN_WIDTH, SCREEN_HEIGHT - WATER_BLUE_TOP)) # Water

    # Draw Player (simple representation)
    pygame.draw.circle(screen, BROWN, (player_x, player_y - 20), 20) # Head
    pygame.draw.line(screen, BROWN, (player_x, player_y), (player_x, player_y + 40), 10) # Body
    # Draw Fishing Rod
    pygame.draw.line(screen, BLACK, (player_x + 10, player_y - 30), line_start_pos, 5)


    # Draw Fishing Line & Bobber
    if is_line_cast or current_state == STATE_CASTING:
        pygame.draw.line(screen, BLACK, line_start_pos, line_end_pos, 2)
        if bobber_pos:
            pygame.draw.circle(screen, RED, bobber_pos, BOBBER_SIZE)
            if current_state == STATE_FISH_BITING:
                # Visual cue for bite
                draw_text("!", game_font_large, YELLOW, screen, bobber_pos[0], bobber_pos[1] - 40, center=True)

    # UI Text
    draw_text(f"Score: {score}", game_font_medium, BLACK, screen, 10, 10)

    # Instructions / State messages
    if current_state == STATE_IDLE:
        draw_text("Press SPACE to Cast", game_font_medium, BLACK, screen, SCREEN_WIDTH // 2, SCREEN_HEIGHT - 50, center=True)
    elif current_state == STATE_WAITING:
        draw_text("Waiting for a bite...", game_font_small, BLACK, screen, SCREEN_WIDTH // 2, SCREEN_HEIGHT - 50, center=True)
    elif current_state == STATE_FISH_BITING:
        draw_text("FISH ON! Press SPACE!", game_font_medium, RED, screen, SCREEN_WIDTH // 2, SCREEN_HEIGHT - 50, center=True)

    # Display timed messages (like "Hooked!", "Caught Fish!", "Missed!")
    if current_message and time.time() < message_display_timer + current_message_duration:
        font_to_use = game_font_medium
        if "Caught" in current_message: font_to_use = game_font_large
        elif "Hooked" in current_message: font_to_use = game_font_medium
        
        # Determine font based on message content or a parameter if display_timed_message is enhanced
        if "large" in current_message.lower() or "caught" in current_message.lower(): # Heuristic
            font_to_use = game_font_large
        elif "small" in current_message.lower():
            font_to_use = game_font_small
        
        draw_text(current_message, font_to_use, BLACK, screen, SCREEN_WIDTH // 2, SCREEN_HEIGHT // 3, center=True)


    pygame.display.flip()  # Update the full display
    clock.tick(FPS)        # Cap the framerate

# --- Quit Pygame ---
pygame.quit()
sys.exit()

