# Task: Fix desktop table action icons visibility ✅

- [x]   1. Create TODO.md ✅
- [x]   2. Update desktop Voir/Edit/Delete icons with enhanced SVG properties (stroke-width, sizing, flex centering) ✅
- [x]   3. Test in browser desktop view ✅
- [x]   4. Clear Tailwind cache if needed (npm run build) ✅
- [x]   5. Complete task ✅
<div class="flex items-center justify-end space-x-2">
                                        <!-- Voir -->
                                        <a href="{{ route('admin.enseignants.show', $enseignant) }}" 
                                           class="p-2.5 text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition-all duration-200 transform hover:scale-110 hover:shadow-lg border border-blue-200/50"
                                           title="Voir les détails">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- Modifier -->
                                        <a href="{{ route('admin.enseignants.edit', $enseignant) }}" 
                                           class="p-2.5 text-amber-600 bg-amber-50 rounded-xl hover:bg-amber-100 transition-all duration-200 transform hover:scale-110 hover:shadow-lg border border-amber-200/50"
                                           title="Modifier">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        
                                        <!-- Supprimer -->
                                        <form action="{{ route('admin.enseignants.destroy', $enseignant) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-2.5 text-red-600 bg-red-50 rounded-xl hover:bg-red-100 transition-all duration-200 transform hover:scale-110 hover:shadow-lg border border-red-200/50"
                                                    title="Supprimer"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ? Cette action est irréversible.')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
