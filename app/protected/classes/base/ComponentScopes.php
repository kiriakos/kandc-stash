<?php
class ComponentScopes
{
    /**
     * Components of this scope are instance local, they are instanciated once 
     * for each object
     */
    const INSTANCE = 1;
    
    /**
     * Components of this type instanciate once per request and refferences to 
     * them are injected into their dependents
     */
    const REQUEST = 2;
    
    /**
     * Components of this type are persisted on request end and reloaded once 
     * the session gets acctivated again in a follow up request.
     */
    const SESSION = 3;

    /**
     * Components of this type are simulating a factory behavior. Each time the
     * Dependency getter is invoked a new instance of the component is created.
     */
    const ACCESS = 4;
}